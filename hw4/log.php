<?php
include_once(__DIR__.'/constants.php');
include_once(__DIR__ . '/models/logs.php');
addLog();

$detailedMode=isset($_GET['file']);
$error=false;
if ($detailedMode) {
    $file=$_GET['file']??'';
    $logs=getLogFile($file);
    if (null===$logs) $error=true;
} else {
    $files= getLogFiles();
}
?>
<?php if ($detailedMode && $error):?>
<h1>Файл логов не найден</h1>
<br>
<br>
<a href="log.php">Вернутся на предыдущую страницу</a>
<? elseif($detailedMode && !$error):?>
<h1><?="$file:"?></h1>
<table border=1>
    <tr>
    <th>Time</th><th>From</th><th>To</th><th>METHOD</th><th>REFERER</th>
    </tr>
    <?php foreach($logs as $item):?>
    <tr>
    <td><?=$item['time']?></td>
    <td><?=$item['ip']?></td>
    <td><?=$item['uri']?></td>
    <td><?=$item['method']?></td>
    <td><?=$item['referer']?></td>
    </tr>
    <?endforeach?>
</table>
<br>
<br>
<a href="log.php">Вернутся на предыдущую страницу</a>
<?else:?>
<h1>Список логов</h1>
<ol>
    <?php foreach($files as $file):?>
    <li><a href="log.php?file=<?=$file?>"><?=$file?></a></li>
    <?endforeach?>
</ol>
<br>
<br>
<a href="index.php">Вернутся на главную страницу</a>
<?endif?>