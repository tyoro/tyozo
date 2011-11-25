<?php
require_once 'head.inc';

$dir = opendir($DIR_PATH);

$fileNames = Array();
$i=0;
$page = isset($_GET['page'])?$_GET['page']:0;
while($file_name = readdir($dir)) {
    if( is_file("{$DIR_PATH}{$file_name}") && preg_match( '/\.png$/', $file_name ) ) {
        $files[] =  array( 'name'=>$file_name, 'time'=>filemtime("{$DIR_PATH}{$file_name}"));
    }
}
closedir($dir);

usort( $files, function($a,$b){ return $b['time'] - $a['time']; } );

foreach( $files as $file ){
	if(  $i>= $page*$PER_PAGE ){
    	$tpl->setCurrentBlock('list');
    	$tpl->setVariable( 'name',$DIR_PATH.$file['name']);
    	$tpl->setVariable( 'time',date( "m/d G:i", $file['time']));
    	$tpl->parseCurrentBlock();
		if( $i > $PER_PAGE * ($page+1) ){ $next = true; break; }
	}
	$i++;
}
if( $next && $i < count($files)  ){
	$tpl->setCurrentBlock('next');
	$tpl->setVariable( 'page',$page+1);
	$tpl->parseCurrentBlock();
}

require_once 'foot.inc';
?>
