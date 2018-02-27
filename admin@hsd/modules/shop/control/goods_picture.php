<?php
/**
 * 相册管理
 *
 *
 *
 *
 * @跨境优品
 * @license    http://www.kjyp360.com
 * @link
 */



defined('ByShopKJYP') or exit('Access Invalid!');

class goods_pictureControl extends SystemControl{
    public function __construct(){
        parent::__construct();
		Tpl::setDirquna('shop');
		Language::read('goods_album');
    }

    public function indexOp() {
      	Tpl::showpage('goods_picture.index');
    }
	
	/**
	 * 取节点名称
	 */
	public function get_nodeOp(){
		$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] :0;
		$temp = Model()->query("select * from channel where cha_parent = {$node}");
		$rslt = array();
		foreach($temp as $v) {
			$count = Model()->query("select count(*) as count from channel where cha_parent = {$v['cha_id']}");
			$rslt[] = array('id' => $v['cha_id'], 'text' => $v['cha_name'], 'children' => ($count[0]['count']>0));
		}
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($rslt);
		exit();
	}
	
	/**
	 * 修改节点名称
	 */
	public function rename_nodeOp(){
		$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
		$cha_name = isset($_GET['text']) ? $_GET['text'] : 'Renamed node';
		$rslt = Model()->execute("update channel set cha_name = '{$cha_name}' where cha_id = {$node}");
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($rslt);
		exit();
	}
	
	/**
	 * 新建节点名称
	 */
	public function create_nodeOp(){
		$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
		$cha_name = isset($_GET['text']) ? $_GET['text'] : 'New node';
		$position = isset($_GET['position']) ? (int)$_GET['position'] : 0;
		$cha_datetime = date('Y-m-d H:i:s',time());
		$rslt = Model()->execute("insert into channel (cha_name,cha_parent,cha_datetime) values ('{$cha_name}',{$node},'{$cha_datetime}')");
		$id = Model()->getLastId();
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode(array('id'=>$id));
		exit();
		
	}
	
	/**
	 * 删除节点
	 */
	public function delete_nodeOp(){
		header('Content-Type: application/json; charset=utf-8');
		$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
		$res = array();
		$res['state'] = false;
		$count = Model()->query("select count(*) as count from channel where cha_parent = {$node}");
		if($count[0]['count']>1){
			$res['msg'] = "此目录下有子目录,请先删除子目录!";				
			echo json_encode($res);
			exit();
		}
		$count = Model()->query("select count(*) as count from shopnc_picture  where pic_channel = {$node}");
		if($count[0]['count']>0){
			$res['msg'] = "此目录下有图片,请先删除所有图片!";				
			echo json_encode($res);
			exit();
		}
		$rslt = Model()->execute("delete from channel  where cha_id = {$node}");
		if($rslt){
			$res['state'] = true;
		}else{
			$res['msg'] = "操作失败,请重试!";	
		}
		echo json_encode($res);
		exit();
	}
	
	/**
	 * 取节点内容
	 */
	public function get_contentOp(){
		$model = Model();
		$node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : 0;
		//$node = explode(':', $node);
		//$res = $this->_get_child(5);
	    $condition = array();
        $condition['pic_channel'] = $node;
        $list = $model->table('picture')->where($condition)->order('pic_name asc,pic_id desc')->page(14)->select();
		if(!empty($list))
        {
            foreach ($list as $key => $value) {
                if($value['pic_atalog']!="")
                {
                    $list[$key]['pic_path_240']=$value['pic_atalog']."/".$value['pic_path_240'];
					$list[$key]['pic_path']=$value['pic_atalog']."/".$value['pic_path'];
                }
            }
        }
        $show_page = $model->showpage();
        Tpl::output('page',$show_page);
        Tpl::output('list',$list);
        Tpl::output('title',$title);
		Tpl::output('pic_channel',$node);
		Tpl::showpage('goods_picture.pic_list' ,'null_layout');
	}
	
	/**
	 * 上传图片
	 */
    public function image_uploadOp() {
    		
    	if (! empty ( $_POST ['category_id'] )) {
            $category_id = intval ( $_POST ['category_id'] );
        } else {
            $error = '上传 图片失败';
            $data['state'] = 'false';
            $data['message'] = $error;
            $data['origin_file_name'] = $_FILES["file"]["name"];
            echo json_encode($data);
            exit();
        }
		
	
		$tempFile = $_FILES["file"]["tmp_name"];
		$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
		$arr = explode('.', $_FILES["file"]["name"]);
		$myname = sprintf('%010d',time() - 946656000).sprintf('%03d', microtime() * 1000).sprintf('%04d', mt_rand(0,9999));		
		$newfilename=$myname.".".end($arr);  //重命名图片
		
		$oldname = str_replace('.'.end($arr), "", $_FILES["file"]["name"]);
		
		$pic_atalog = date("Ym",time());
		if(!is_dir($targetPath.'picture/uploadfile/'.$pic_atalog.'/')) {
	   		mkdir($targetPath.'picture/uploadfile/'.$pic_atalog.'/', 0777, true);
		}
		
		$targetFile =  $targetPath.'picture/uploadfile/'.$pic_atalog."/".$newfilename;
		
		move_uploaded_file($tempFile,$targetFile);
	
		$pic_channel = strip_tags($_REQUEST[pic_channel],'');  
		$pic_mame = strip_tags($_REQUEST[pic_name],'');  
		$pic_path = $newfilename;
		// 原始图片
		$img1 = $targetPath.'picture/uploadfile/'.$pic_atalog.'/'.$newfilename;
		// 水印后的图片
		//$img2 = './uploadfile/x_'.$newfilename[$i];
		// 水印
		//$water = './images/water.gif';
		$img = Model('image');
		// center center 裁剪
		$img->param($img1)->thumb($targetPath.'picture/uploadfile/'.$pic_atalog.'/'.'x0_'.$newfilename, 360,360,1);
		$img->param($img1)->thumb($targetPath.'picture/uploadfile/'.$pic_atalog.'/'.'x1_'.$newfilename, 60,60,1);
		$img->param($img1)->thumb($targetPath.'picture/uploadfile/'.$pic_atalog.'/'.'x2_'.$newfilename, 240,240,1);
		// 右下角添加水印
		//$img->param($img1)->water($img2,$water,9);
		$pic_path_s = 'x0_'.$newfilename;
		$pic_path_60='x1_'.$newfilename;
		$pic_path_240='x2_'.$newfilename;
		
		$insert_array = array();
        $insert_array['pic_channel'] = $category_id;
        $insert_array['pic_name'] = $oldname;
        $insert_array['pic_path'] = $pic_path;
        $insert_array['pic_path_60'] = $pic_path_60;
        $insert_array['pic_path_240'] = $pic_path_240;
        $insert_array['pic_path_s'] = $pic_path_s;
        $insert_array['pic_atalog'] = $pic_atalog;
        $insert_array['pic_datetime'] = date('Y-m-d H:i:s',time());
		$result = Db::insert('picture',$insert_array);
		
		$data = array ();
        $data['file_id'] = $result;
        $data['file_name'] = $newfilename;
        $data['origin_file_name'] = $_FILES["file"]["name"];
        $data['file_path'] = $targetPath.'picture/uploadfile/'.$pic_atalog.'/';
        $data['instance'] = $_GET['instance'];
        $data['state'] = 'true';
        /**
         * 整理为json格式
         */
        $output = json_encode ( $data );
        echo $output;
		
	}
	
	/**
	 * 删除图片
	 */
	public function album_pic_delOp(){
		if (empty($_POST)) $_POST = $_GET;
        if(empty($_POST['id'])) {
            showDialog("参数有误,请重试");
        }
		$pic_info = Model('picture')->where(array('pic_id'=>$_POST['id']))->find();
		$result = Model('picture')->where(array('pic_id'=>$_POST['id']))->delete();
		
		if($result){
			if($pic_info['pic_atalog']!="")
			{
				$pic_atalog = $pic_info['pic_atalog']."/";
			}
			else
			{
				$pic_atalog = "";
			}
			
			$filePath=BASE_PATH."/.././picture/uploadfile/".$pic_atalog.$pic_info[pic_path];
			$filePathx0=BASE_PATH."/.././picture/uploadfile/".$pic_atalog."x0_".$pic_info[pic_path];
			$filePathx1=BASE_PATH."/.././picture/uploadfile/".$pic_atalog."x1_".$pic_info[pic_path];
			$filePathx2=BASE_PATH."/.././picture/uploadfile/".$pic_atalog."x2_".$pic_info[pic_path];
			unlink($filePath);
			unlink($filePathx0);
			unlink($filePathx1);
			unlink($filePathx2);
			showDialog("删除成功",'index.php?m=goods_picture','succ');
		}else{
			showDialog("参数有误,请重试");
		}
	}

	/**
	 * 更改图片名称
	 */
	public function change_pic_nameOp(){
		$pic_id = $_POST['id'];
		$pic_name = $_POST['name'];
		$result = 	Model('picture')->where(array('pic_id'=>$pic_id))->update(array('pic_name'=>$pic_name));
		if($result){
			echo "true";
		}else{
			echo "false";
		}
	}
	
	/**
     * 替换图片
     */
    public function replace_image_uploadOp() {
        $file = $_GET['id'];
        $tpl_array = explode('_', $file);
        $pic_id = intval(end($tpl_array));
		$pic_info = Model('picture')->where(array('pic_id'=>$pic_id))->find();		
	
		if (substr(strrchr($pic_info['pic_path'], "."), 1) != substr(strrchr($_FILES[$file]["name"], "."), 1)) {
		 	echo json_encode( array('state' => 'false', 'message' => "后缀名必须相同") );
		 	exit();
		}		
		$tempFile = $_FILES[$file]['tmp_name'];
		$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/'; 
		if($pic_info['pic_atalog']!=""){
			 	$pic_atalog=$pic_info['pic_atalog']."/";
		}else{
			$pic_atalog="";
		}
		$targetFile =  str_replace('//','/',$targetPath) ."picture/uploadfile/".$pic_atalog.$pic_info['pic_path'];
		
		move_uploaded_file($tempFile,$targetFile);		
		$img1 = str_replace('//','/',$targetPath).'picture/uploadfile/'.$pic_atalog.$pic_info['pic_path'];
		$img = Model('image');
		 // center center 裁剪
		$img->param($img1)->thumb(str_replace('//','/',$targetPath).'picture/uploadfile/'.$pic_atalog.'x0_'.$pic_info['pic_path'], 360,360,1);
		$img->param($img1)->thumb(str_replace('//','/',$targetPath).'picture/uploadfile/'.$pic_atalog.'x1_'.$pic_info['pic_path'], 60,60,1);
		$img->param($img1)->thumb(str_replace('//','/',$targetPath).'picture/uploadfile/'.$pic_atalog.'x2_'.$pic_info['pic_path'], 240,240,1);
		
		echo json_encode( array('state' => 'true', 'id' => $pic_id) );
        exit();
    }
	
	private function _get_child($cha_parent){
		
		//static $cha_id = $cha_id.",";
		$channel = $Model()->query("select * from channel where cha_parent = {$cha_parent}");
		print_r($channel);
		if(!empty($channel)){
			foreach($channel as $key => $value){
				$this->_get_child($value['cha_parent']);
			}
		}else{
			return $cha_id;
		}
		
	}
}
