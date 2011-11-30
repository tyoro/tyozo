<?php
require_once 'Calendar/Month.php';
require_once 'Calendar/Decorator/Weekday.php';
require_once 'Calendar/Decorator/Wrapper.php';
require_once 'Calendar/Decorator/Uri.php';
require_once 'head.inc';

$dir = opendir($DIR_PATH);

$fileNames = Array();
$i=0;

$y = isset($_GET['y'])?$_GET['y']-0:date('Y');
$m = isset($_GET['m'])?$_GET['m']-0:date('m');

while($file_name = readdir($dir)) {
    if( is_file("{$DIR_PATH}{$file_name}") && preg_match( '/\.png$/', $file_name ) ) {
		$time = filemtime("{$DIR_PATH}{$file_name}");
		if( date( "Yn",$time) == $y.$m ){
        	$files[date("j",$time)][] =  array( 'name'=>$file_name, 'time'=>$time);
		}
    }
}
closedir($dir);

$Month = new Calendar_Month($y, $m);
$Link = new Calendar_Decorator_Uri($Month);
$CalMonth = new Calendar_Decorator_Wrapper($Month);
$CalMonth->build();

$weekDayStrings = array( '月', '火', '水', '木', '金', '土', '日');

while ($Day = $CalMonth->fetch('Calendar_Decorator_Weekday')){
	if( isset( $files[$Day->thisDay()] ) ){
		usort( $files[$Day->thisDay()], function($a,$b){ return $b['time'] - $a['time']; } );
		foreach( $files[$Day->thisDay()] as $file ){
			$tpl->setCurrentBlock('list');
			$tpl->setVariable( 'name',$DIR_PATH.$file['name']);
			$tpl->parseCurrentBlock();
		}
	}

	$tpl->setCurrentBlock("calendar_day");
	$tpl->setVariable("day", $Day->thisDay());
	$tpl->setVariable("weekDay", $weekDayStrings[$Day->thisWeekDay()] );
	$tpl->setVariable("weekDayClass", 'weekDay'.$Day->thisWeekDay() );
	$tpl->parseCurrentBlock("calendar_day");
}

$tpl->setCurrentBlock("calendar");

$Link->setFragments( 'y', 'm' );
$tpl->setVariable("now",$Link->thisYear().' '.$Link->thisMonth());

$prevMonth = $Link->prevMonth('object');
$tpl->setVariable("prev",'<a href="calendar.php?'.$Link->prev('month').'">&lt;&lt;</a>'  );

$nextMonth = $Link->nextMonth('object');
$tpl->setVariable("next",'<a href="calendar.php?'.$Link->next('month').'">&gt;&gt;</a>'  );

$tpl->parse("calendar");

require_once 'foot.inc';
?>
