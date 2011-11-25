<?php
ob_start();

include_once('HTML/Template/IT.php');
//require_once 'lib/debug.inc';
require_once 'lib/util.inc';
require_once 'conf.inc';


session_start();

/* HTML_Template_ITオブジェクトの生成 */
$tpl = new HTML_Template_IT('./template/');

$tpl->loadTemplatefile('head.tpl.html', true, false);
$head = $tpl->get();
$tpl->loadTemplatefile('foot.tpl.html', true, false);
$foot = $tpl->get();

/* テンプレートファイルの読み込み */
$tpl->loadTemplatefile(strrchr($_SERVER["SCRIPT_NAME"],'/').'.tpl.html', true, true);

$tpl->setVariable('head',$head);
$tpl->setVariable('foot',$foot);
