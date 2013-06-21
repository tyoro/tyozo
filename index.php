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
$cnt = count($files);

for( $i = $page*$PER_PAGE ; $i<($page+1)*$PER_PAGE && $i<$cnt ;$i++)
{
	$tpl->setCurrentBlock('list');
	$tpl->setVariable( 'size',$ITEM_SIZE);
	$tpl->setVariable( 'name',$DIR_PATH.$files[$i]['name']);
	$tpl->setVariable( 'time',date( "m/d G:i", $files[$i]['time']));
	$tpl->parseCurrentBlock();
}
if( $i < $cnt  ){
	$tpl->setCurrentBlock('next');
	$tpl->setVariable( 'page',$page+1);
	$tpl->parseCurrentBlock();
}
	
require_once 'foot.inc';
?>
