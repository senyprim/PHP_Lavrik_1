<?php

function checkLogFileName(string $file): bool
{
    return !!preg_match(LOG_REGEX_FILE, $file);
}
function hasLogFileName(string $file): bool
{
    return checkLogFileName($file) && is_file(LOG_DIRECTORY . "/$file");
}

function getLogFile(?string $file): ?array
{
    if (empty($file) || !hasLogFileName($file)) {
        return null;
    }

    return array_map(function ($line) {
        return logsStrToArr($line);
    },
        file(LOG_DIRECTORY . "/$file")
    );
}
function getLogFiles(): array
{
    $result=[];
    foreach(scandir(LOG_DIRECTORY) as $file){
        if (is_file(LOG_DIRECTORY . "/$file") && checkLogFileName($file)){
            $result[]=pathinfo($file,PATHINFO_FILENAME);
        }
    };
    return $result;
}
function logsStrToArr(string $str): array
{
    $str = rtrim($str);
    $parts = json_decode($str,true);
    return $parts;
}

function getLogInfo():array{
    return [
        'time' => date('H:i:s'),
        'ip' => $_SERVER['REMOTE_ADDR'],
        'uri' => $_SERVER['REQUEST_URI'],
        'method' => $_SERVER['REQUEST_METHOD'],
        'referer' => $_SERVER['HTTP_REFERER'] ?? '',
    ];
};

function addLog($info): bool
{
    $filename = date("Y-m-d");
    $line = json_encode($info) . "\n";
    file_put_contents(LOG_DIRECTORY . "/$filename.txt", $line, FILE_APPEND);
    return true;
}
