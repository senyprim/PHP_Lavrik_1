<?php
$p = realpath(__DIR__ . '/../db/logs');
define('LOG_DIRECTORY', $p);
define('REGEX_LOG_FILE', '/^\d{4}-\d{2}-\d{2}\.txt$/i');

function checkLogFileName(string $file): bool
{
    if (empty($file)) return false;
    return !!preg_match(REGEX_LOG_FILE, $file);
}
function hasLogFileName(string $file): bool
{
    return checkLogFileName($file) && is_file(LOG_DIRECTORY . "/$file");
}

function getLogFile(string $file): ?array
{
    if (!hasLogFileName($file)) {
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
    return array_filter(
        scandir(LOG_DIRECTORY),
        function ($file) {
            return is_file(LOG_DIRECTORY . "/$file") && checkLogFileName($file);
        }
    );
}
function logsStrToArr(string $str): array
{
    $str = rtrim($str);
    $parts = json_decode($str,true);
    return $parts;
}

function addLog(): bool
{
    $filename = date("Y-m-d");
    $info = [
        'time' => date('H:i:s'),
        'ip' => $_SERVER['REMOTE_ADDR'],
        'uri' => $_SERVER['REQUEST_URI'],
        'method' => $_SERVER['REQUEST_METHOD'],
        'referer' => $_SERVER['HTTP_REFERER'] ?? '',
    ];
    $line = json_encode($info) . "\n";
    file_put_contents(LOG_DIRECTORY . "/$filename.txt", $line, FILE_APPEND);
    return true;
}
