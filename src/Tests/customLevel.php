<?php

use Sim\Logger\Handler\File\FileHandler;
use Sim\Logger\Logger;

include_once '../../vendor/autoload.php';

$logger = new Logger(new FileHandler(__DIR__ . DIRECTORY_SEPARATOR . 'logs.log'));

$message = 'this is a log message.';
$res = $logger->format('{level}: {date} - {message} | {randomParameter}')->extraParameters([
    'randomParameter' => rand(10000, 100),
])->log($message, 'custom level');

if($res) {
    echo "Log has been appended";
} else {
    echo "An error occurred";
}