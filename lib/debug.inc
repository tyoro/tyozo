<?php
	error_reporting(E_ERROR);

function d() {
  echo '<pre style="background:#fff;color:#333;border:1px solid #ccc;margin:2px;padding:4px;font-family:monospace;font-size:12px">';
  foreach (func_get_args() as $v) var_dump($v);
  echo '</pre>';
}
function p( $var, $label = FALSE ){
if( $label ){
$text = '' . $label . ' : ';
}else{
$text = '';
}
$text.= htmlspecialchars( print_r($var,1) );
$text.= '';
$text = preg_replace( '/(Array)([\r\n])/', '$1$2', $text );
$text = preg_replace( '/ (\[.+?\]) /' , ' $1 ' , $text );
$text = preg_replace( '/ (\=\>) /' , ' $1 ', $text );
echo $text;
}