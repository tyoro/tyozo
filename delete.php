<?php

include_once "./conf.inc";

if( empty($_POST['url']) ){
	print 'param not found.';
	exit;
}

$file_path = $DIR_PATH.$_POST['url'].'.png';
if( !is_public_file( $public_dir ,$file_path, false ) ){
	print 'file not found.';
	exit;
}

if( !unlink( $file_path )){
	print 'file delete error.';
	exit;
}

print "success.";


function is_public_file($public_dir, $path, $permit_sub_dir = true )
{
    if (! is_string($path)) {
        return false;
    }

    $realpath = realpath($path);

    if ($realpath === false) {
        return false;
    }

    if (file_exists($realpath) === false) {
        return false;
    }

    if (strncmp($public_dir, $realpath, strlen($public_dir)) !== 0) {
        return false;
    }

	if( !$permit_sub_dir && substr_count( $public_dir, '/' ) !== substr_count( $realpath, '/' ) ){
		return false;
	}
    return true;
}
