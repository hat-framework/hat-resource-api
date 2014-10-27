<?php

$ds = DIRECTORY_SEPARATOR;
require_once dirname(__FILE__) ."{$ds}..{$ds}vendor{$ds}autoload.php";
require_once dirname(__FILE__) ."{$ds}..{$ds}autoload.php";

$file = dirname(__FILE__) ."{$ds}temp.php";
if(file_exists($file)){require_once $file;}
