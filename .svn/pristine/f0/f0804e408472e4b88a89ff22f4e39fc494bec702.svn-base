<?php
/**
 * 微信接口
 *
 *
 *
 *
 * @跨境优品
 * @license    http://www.kjyp360.com
 * @link
 */

//use Shopwwi\Tpl;

defined('ByShopKJYP') or exit('Access Invalid!');
class menuControl extends SystemControl{
    
    public function __construct(){
       
        parent::__construct();
    }

    public function indexOp() {
        $model_wxch_menu = Model('wxch_menu');
        if($_POST["form_submit"]=="ok")
        {
            $level = 1;
            $aid = 0;
            $model_wxch_menu->clearMenu();
            $first_type = $_POST['first_type'];
            $first = $_POST['first'];
            $first_value = $_POST['first_value'];
            foreach($first as $k=>$v)
            {
        
                $insert=array();
                $insert['menu_type']=$first_type[$k];
                $insert['level']=$level;
                $insert['name']=$first[$k];
                $insert['value']=$first_value[$k];
                $insert['aid']=$aid;
        
                $model_wxch_menu->addMenu($insert);
        
            }
            $level = 2;
            $aid = 1;
            $menu_type1 = $_POST['menu_type1'];
            $second1 = $_POST['second1'];
            $value1 = $_POST['value1'];
            foreach($second1 as $k=>$v)
            {
                $insert=array();
                $insert['menu_type']=$menu_type1[$k];
                $insert['level']=$level;
                $insert['name']=$second1[$k];
                $insert['value']=$value1[$k];
                $insert['aid']=$aid;
        
                $model_wxch_menu->addMenu($insert);
        
            }
            $aid = 2;
            $menu_type2 = $_POST['menu_type2'];
            $second2 = $_POST['second2'];
            $value2 = $_POST['value2'];
            foreach($second2 as $k=>$v)
            {
                $insert=array();
                $insert['menu_type']=$menu_type2[$k];
                $insert['level']=$level;
                $insert['name']=$second2[$k];
                $insert['value']=$value2[$k];
                $insert['aid']=$aid;
        
                $model_wxch_menu->addMenu($insert);
                	
            }
            $aid = 3;
            $menu_type3 = $_POST['menu_type3'];
            $second3 = $_POST['second3'];
            $value3 = $_POST['value3'];
            foreach($second2 as $k=>$v)
            {
                $insert=array();
                $insert['menu_type']=$menu_type3[$k];
                $insert['level']=$level;
                $insert['name']=$second3[$k];
                $insert['value']=$value3[$k];
                $insert['aid']=$aid;
        
                $model_wxch_menu->addMenu($insert);
        
            }
        
        
            $ret_msg = $this->create_menu();
        
        
            if($ret_msg->errmsg == 'ok')
            {
        
                showMessage("设置成功");
            }
            else
            {
                if($ret_msg)
                {
                    print_r($ret_msg);
                    echo '<br>';
                    echo '请将以上错误内容发送给';
                }
                else
                {
                    	
                    showMessage("生成菜单失败，请重新生成一次");
                }
            }
        }
        else
        {
        
            $data = array();
            $data['first'] = $model_wxch_menu->getMenuList(array('aid'=>0));
            $data['second1'] = $model_wxch_menu->getMenuList(array('aid'=>1));
            $i = 0;
            foreach($data['second1'] as $k=>$v)
            {
                $i++;
                $data['second1'][$k]['num'] = $i;
            }
        
            $data['second2'] =  $model_wxch_menu->getMenuList(array('aid'=>2));
            $i = 0;
            foreach($data['second2'] as $k=>$v)
            {
                $i++;
                $data['second2'][$k]['num'] = $i;
            }
            	
            $data['second3'] =  $model_wxch_menu->getMenuList(array('aid'=>3));
            $i = 0;
            foreach($data['second3'] as $k=>$v)
            {
                $i++;
                $data['second3'][$k]['num'] = $i;
            }
            Tpl::output('data',$data);
            //print_r($data);
        
        }
        Tpl::setDirquna('wxshop');
        Tpl::showpage('wxch_menu.index');
    }
    private function create_menu()
    {
        $model_wxch_menu = Model('wxch_menu');
        $this->access_token();
    
    
        $model_wxch_config = Model('wxch_config');
        $r=$model_wxch_config->getConfigInfo(array('id'=>1));
        $ret = $r['access_token'];
        $access_token = $ret;
    
        if(strlen($access_token) >= 64)
        {
            	
    
    
            $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$access_token;
            $data = array();
            	
            $data['first'] = $model_wxch_menu->getMenuList(array('aid'=>0));
            foreach($data['first'] as $k=>$v)
            {
                if(empty($data['first'][$k]['name']))
                {
                    unset($data['first'][$k]);
                }
                else
                {
                    $data['first'][$k]['name'] = urlencode($v['name']);
                    if($v['menu_type'] == 'click')
                    {
                        $data['first'][$k]['array'] = array('type'=>$v['menu_type'],'name'=>$data['first'][$k]['name'],'key'=>$v['value']);
                    }
                    elseif($v['menu_type'] == 'view')
                    {
                        $data['first'][$k]['array'] = array('type'=>$v['menu_type'],'name'=>$data['first'][$k]['name'],'url'=>$v['value']);
                    }
                }
            }
            	
    
            $data['second1'] =$model_wxch_menu->getMenuList(array('aid'=>1));;
            $second1 = 'no';
            foreach($data['second1'] as $k=>$v)
            {
                if(empty($data['second1'][$k]['name']))
                {
                    unset($data['second1'][$k]);
                }
                else
                {
                    $v['value'] = urlencode($v['value']);
                    $v['name'] = urlencode($v['name']);
                    if($v['menu_type'] == 'click')
                    {
                        $array1[] = array('type'=>$v['menu_type'],'name'=>$v['name'],'key'=>$v['value']);
                    }
                    elseif($v['menu_type'] == 'view')
                    {
                        $array1[] = array('type'=>$v['menu_type'],'name'=>$v['name'],'url'=>$v['value']);
                    }
                    $second1 = 'yes';
                }
            }
            	
            $data['second2'] =$model_wxch_menu->getMenuList(array('aid'=>2));;
            $second2 = 'no';
            foreach($data['second2'] as $k=>$v)
            {
                if(empty($data['second2'][$k]['name']))
                {
                    unset($data['second2'][$k]);
                }
                else
                {
                    $v['value'] = urlencode($v['value']);
                    $v['name'] = urlencode($v['name']);
                    if($v['menu_type'] == 'click')
                    {
                        $array2[] = array('type'=>$v['menu_type'],'name'=>$v['name'],'key'=>$v['value']);
                    }
                    elseif($v['menu_type'] == 'view')
                    {
                        $array2[] = array('type'=>$v['menu_type'],'name'=>$v['name'],'url'=>$v['value']);
                    }
                    $second2 = 'yes';
                }
            }
            	
            $data['second3'] = $model_wxch_menu->getMenuList(array('aid'=>3));
            $second3 = 'no';
            foreach($data['second3'] as $k=>$v)
            {
                if(empty($data['second3'][$k]['name']))
                {
                    unset($data['second3'][$k]);
                }
                else
                {
                    $v['value'] = urlencode($v['value']);
                    $v['name'] = urlencode($v['name']);
                    if($v['menu_type'] == 'click')
                    {
                        $array3[] = array('type'=>$v['menu_type'],'name'=>$v['name'],'key'=>$v['value']);
                    }
                    elseif($v['menu_type'] == 'view')
                    {
                        $array3[] = array('type'=>$v['menu_type'],'name'=>$v['name'],'url'=>$v['value']);
                    }
                    $second3 = 'yes';
                }
            }
            if($second1 == 'yes')
            {
                $sarr1 = array('name'=>$data['first'][0]['name'],'sub_button'=>$array1);
            }
            elseif($second1 == 'no')
            {
                $sarr1 = $data['first'][0]['array'];
            }
            if($second2 == 'yes')
            {
                $sarr2 = array('name'=>$data['first'][1]['name'],'sub_button'=>$array2);
            }
            elseif($second2 == 'no')
            {
                $sarr2 = $data['first'][1]['array'];
            }
            if($second3 == 'yes')
            {
                $sarr3 = array('name'=>$data['first'][2]['name'],'sub_button'=>$array3);
            }
            elseif($second3 == 'no')
            {
                $sarr3 = $data['first'][2]['array'];
            }
            $arr = array('button' => array($sarr1,$sarr2,$sarr3) );
            	
            $menu = urldecode(json_encode($arr));
            $ret_json = $this->curl_grab_page($url,$menu);
            $ret = json_decode($ret_json);
            	
            if(!$ret->errcode == '0')
            {
                $access_token = $this->new_access_token();
                $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$access_token;
                $ret_json = $this->curl_grab_page($url,$menu);
                $ret = json_decode($ret_json);
            }
            return $ret;
        }
        else
        {
            $access_token = $this->new_access_token();
    
            return FALSE;
        }
    }
    private function access_token()
    {
        $model_wxch_config = Model('wxch_config');
        $ret = $model_wxch_config->getConfigInfo(array('id'=>1));
        $appid = $ret['appid'];
        $appsecret = $ret['appsecret'];
        $access_token = $ret['access_token'];
        $dateline = $ret['dateline'];
        $time = time();
        if(($time - $dateline) >= 7200)
        {
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
            if(function_exists(curl_exec))
            {
                $ret_json = $this->curl_get_contents($url);
            }
            else
            {
                echo '您的服务器不支持:curl_exec函数，无法生成菜单';
                exit;
            }
            $ret = json_decode($ret_json);
            if($ret->access_token)
            {
                $update['access_token']=$ret->access_token;
                $update['dateline']=$time;
                $res=$model_wxch_config->editConfig($update, array('id'=>1));
            }
        }
        elseif(empty($access_token))
        {
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
            if(function_exists(curl_exec))
            {
                $ret_json = $this->curl_get_contents($url);
            }
            else
            {
                echo '您的服务器不支持:curl_exec函数，无法生成菜单';
                exit;
            }
            $ret = json_decode($ret_json);
            if($ret->access_token)
            {
                $update['access_token']=$ret->access_token;
                $update['dateline']=$time;
                $res=$model_wxch_config->editConfig($update, array('id'=>1));
            }
        }
    }
    private function new_access_token()
    {
        $time = time();
        $model_wxch_config = Model('wxch_config');
        $ret = $model_wxch_config->getConfigInfo(array('id'=>1));;
        $appid = $ret['appid'];
        $appsecret = $ret['appsecret'];
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
        if(function_exists(curl_exec))
        {
            $ret_json = $this->curl_get_contents($url);
        }
        else
        {
            echo '您的服务器不支持:curl_exec函数，无法生成菜单';
            exit;
        }
        $ret = json_decode($ret_json);
        if($ret->access_token)
        {
            $update['access_token']=$ret->access_token;
            $update['dateline']=$time;
            $res=$model_wxch_config->editConfig($update, array('id'=>1));
            	
        }
        return $ret->access_token;
    }
    private function wxch_upload_file($upload)
    {
        $image = new cls_image();
        $res = $image->upload_image($upload);
        if($res)
        {
            return $res;
        }
        else
        {
            return false;
        }
    }
    private function curl_redir_exec($ch)
    {
        static $curl_loops = 0;
        static $curl_max_loops = 20;
        if ($curl_loops++ >= $curl_max_loops)
        {
            $curl_loops = 0;
            return FALSE;
        }
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        list($header, $data) = explode("\n\n", $data, 2);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_code == 301 || $http_code == 302)
        {
            $matches = array();
            preg_match('/Location:(.*?)\n/', $header, $matches);
            $url = @parse_url(trim(array_pop($matches)));
            if (!$url)
            {
                $curl_loops = 0;
                return $data;
            }
            $last_url = parse_url(curl_getinfo($ch, CURLINFO_EFFECTIVE_URL));
            if (!$url['scheme']) $url['scheme'] = $last_url['scheme'];
            if (!$url['host']) $url['host'] = $last_url['host'];
            if (!$url['path']) $url['path'] = $last_url['path'];
            $new_url = $url['scheme'] . '://' . $url['host'] . $url['path'] . ($url['query']?'?'.$url['query']:'');
            curl_setopt($ch, CURLOPT_URL, $new_url);
            debug('Redirecting to', $new_url);
            return curl_redir_exec($ch);
        }
        else
        {
            $curl_loops=0;
            return $data;
        }
    }
    private function curl_get_contents($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_USERAGENT, _USERAGENT_);
        curl_setopt($ch, CURLOPT_REFERER,_REFERER_);
        @curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $r = curl_exec($ch);
        curl_close($ch);
        return $r;
    }
    private function curl_grab_page($url,$data,$proxy='',$proxystatus='',$ref_url='')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($proxystatus == 'true')
        {
            curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, TRUE);
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
    
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        if(!empty($ref_url))
        {
            curl_setopt($ch, CURLOPT_HEADER, TRUE);
            curl_setopt($ch, CURLOPT_REFERER, $ref_url);
        }
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 200);
        @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        ob_start();
        return curl_exec ($ch);
        ob_end_clean();
        curl_close ($ch);
        unset($ch);
    }
}
