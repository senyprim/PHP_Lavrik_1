<?php

$detailedMode=isset($_GET['file']);

$error=false;
if ($detailedMode) {
    $file=$_GET['file']??'';
    $logs=getLogFile($file);
    if (null===$logs) $error=true;
} else {
    $files= getLogFiles();
}
if ($detailedMode && $error){
    $titleView = 'File log not found';
	include(BASE_DIR . '/views/fail.php');
} elseif($detailedMode && !$error){
    $titleView = $file;
	include(BASE_DIR . '/views/log.php');
} else {
    $titleView = 'Список логов';
    include(BASE_DIR . '/views/log-list.php');
};
