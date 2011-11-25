<?php

function checkValue( $val ){
	return !(is_null($val) || !strlen($val) );
}

function drawSystemError($error_msg){
	global $tpl;
	global $head;
	global $foot;
	
	$tpl->loadTemplatefile( 'error.tpl.html', true, true );
	
	$tpl->setVariable( 'error_msg', $error_msg );
	require 'foot.inc';
	exit();
}

