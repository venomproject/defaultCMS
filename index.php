<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$basePath=dirname(__FILE__);
$frameworkPath=$basePath.'/../framework/prado.php';
$assetsPath=$basePath.'/assets';

if(!is_writable($assetsPath))
	die("Please make sure that the directory $assetsPath is writable by Web server process.");

require_once($frameworkPath);

$application=new TApplication;
$application->run();

?>
