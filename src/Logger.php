<?php

namespace Sim\Logger;


use Sim\Logger\Handler\IHandler;

class Logger implements ILogger
{
    /**
     * @var IHandler|null $handler
     */
    protected $handler = null;

    /**
     * @var array $data
     */
    protected $data = [];

    /**
     * @var string $format
     */
    protected $format = '{level}: {date} - {message}';

    /**
     * @var string $date_format
     */
    protected $date_format = 'Y-m-d H:i:s';

    /**
     * @var array $extra_params
     */
    protected $extra_params = [];

    /**
     * @var string $timezone
     */
    protected $timezone;

    /**
     * Logger constructor.
     * @param IHandler|null $handler
     * @param string $format
     * @param string $date_format
     */
    public function __construct(?IHandler $handler = null, $format = '{level}: {date} - {message}', $date_format = 'Y-m-d H:i:s')
    {
        $this->handler = $handler;
        $this->timezone = date_default_timezone_get();
        $this->format($format);
        $this->dateFormat($date_format);
    }

    /**
     * @param IHandler $handler
     * @return ILogger
     */
    public function handler(IHandler $handler): ILogger
    {
        $this->handler = $handler;
        return $this;
    }

    /**
     * @param $message
     * @param string $level
     * @return bool
     */
    public function log($message, $level): bool
    {
        return self::_log($message, $level);
    }

    /**
     * @param $message
     * @return bool
     */
    public function emergency($message): bool
    {
        return self::_log($message, self::EMERGENCY);
    }

    /**
     * @param $message
     * @return bool
     */
    public function alert($message): bool
    {
        return self::_log($message, self::ALERT);
    }

    /**
     * @param $message
     * @return bool
     */
    public function critical($message): bool
    {
        return self::_log($message, self::CRITICAL);
    }

    /**
     * @param $message
     * @return bool
     */
    public function error($message): bool
    {
        return self::_log($message, self::ERROR);
    }

    /**
     * @param $message
     * @return bool
     */
    public function warning($message): bool
    {
        return self::_log($message, self::WARNING);
    }

    /**
     * @param $message
     * @return bool
     */
    public function notice($message): bool
    {
        return self::_log($message, self::NOTICE);
    }

    /**
     * @param $message
     * @return bool
     */
    public function info($message): bool
    {
        return self::_log($message, self::INFO);
    }

    /**
     * @param $message
     * @return bool
     */
    public function debug($message): bool
    {
        return self::_log($message, self::DEBUG);
    }

    /**
     * @param string $format
     * @return ILogger
     */
    public function format(string $format): ILogger
    {
        if (!empty($format)) {
            $this->format = $format;
        }
        return $this;
    }

    /**
     * @param string $format
     * @return ILogger
     */
    public function dateFormat(string $format): ILogger
    {
        if (false !== date($format, time())) {
            $this->date_format = $format;
        }
        return $this;
    }

    /**
     * @param array $parameters
     * @return ILogger
     */
    public function extraParameters(array $parameters): ILogger
    {
        $this->extra_params = $parameters;
        return $this;
    }

    /**
     * @param string $timezone
     * @return ILogger
     */
    public function setTimezone(string $timezone): ILogger
    {
        if (!empty($timezone)) {
            $this->timezone = $timezone;
        }
        return $this;
    }

    /**
     * Log bottleneck
     * @param $message
     * @param $level
     * @return bool
     */
    protected function _log($message, $level): bool
    {
        $level = empty($level) ? self::INFO : $level;
        $date = $this->getTimezoneDate();
        $this->data = [
            'message' => $message,
            'level' => $level,
            'date' => $date,
        ];

        if (is_null($this->handler)) {
            return false;
        }

        $formatted_string = $this->format;
        $this->data = array_merge_recursive($this->extra_params, $this->data);
        foreach ($this->data as $alias => $value) {
            if (is_object($value) || is_array($value)) {
                $entry = json_encode($value);
            } else {
                $entry = (string)$value;
            }
            $formatted_string = str_replace('{' . $alias . '}', $entry, $formatted_string);
        }

        return $this->handler->init()->write($formatted_string, $this->data);
    }

    /**
     * @return string
     */
    protected function getTimezoneDate(): string
    {
        try {
            $dateTime = new \DateTime(null, new \DateTimeZone($this->timezone));
            $dateTime->setTimezone(new \DateTimeZone($this->timezone));
            $date = $dateTime->format($this->date_format);
            return $date . " ({$this->timezone})";
        } catch (\Exception $e) {
            echo $e;
        }
        return 'undefined date';
    }
}