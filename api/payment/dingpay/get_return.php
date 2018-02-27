<?php
$postStr = $_POST[];
$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);

file_put_contents("./postReturn.txt",print_r($postObj,true),FILE_APPEND);