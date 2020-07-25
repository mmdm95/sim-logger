<?php

namespace Sim\Logger;


use Sim\Logger\Handler\IHandler;

interface ILogger
{
    const EMERGENCY = 'emergency';
    const ALERT = 'alert';
    const CRITICAL = 'critical';
    const ERROR = 'error';
    const WARNING = 'warning';
    const NOTICE = 'notice';
    const INFO = 'info';
    const DEBUG = 'debug';

    /**
     * @param IHandler $handler
     * @return ILogger
     */
    public function handler(IHandler $handler): ILogger;

    /**
     * @param $message
     * @param string $level
     * @return bool
     */
    public function log($message, $level): bool;

    /**
     * @param $message
     * @return bool
     */
    public function emergency($message): bool;

    /**
     * @param $message
     * @return bool
     */
    public function alert($message): bool;

    /**
     * @param $message
     * @return bool
     */
    public function critical($message): bool;

    /**
     * @param $message
     * @return bool
     */
    public function error($message): bool;

    /**
     * @param $message
     * @return bool
     */
    public function warning($message): bool;

    /**
     * @param $message
     * @return bool
     */
    public function notice($message): bool;

    /**
     * @param $message
     * @return bool
     */
    public function info($message): bool;

    /**
     * @param $message
     * @return bool
     */
    public function debug($message): bool;

    /**
     * @param string $format
     * @return ILogger
     */
    public function format(string $format): ILogger;

    /**
     * @param string $format
     * @return ILogger
     */
    public function dateFormat(string $format): ILogger;

    /**
     * @param array $parameters
     * @return ILogger
     */
    public function extraParameters(array $parameters): ILogger;

    /**
     * @param string $timezone
     * @return ILogger
     */
    public function setTimezone(string $timezone): ILogger;
}