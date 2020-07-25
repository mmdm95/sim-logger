<?php

namespace Sim\Logger\Handler\File;

use Sim\Logger\Exceptions\FileHandlerException;
use Sim\Logger\Handler\IHandler;

class FileHandler implements IHandler
{
    /**
     * @var string $filename
     */
    protected $filename;

    /**
     * @var resource|null $file_handler
     */
    protected $file_handler = null;

    /**
     * FileHandler constructor.
     * @param string $filename
     */
    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return IHandler
     * @throws FileHandlerException
     */
    public function init(): IHandler
    {
        $this->file_handler = fopen($this->filename, 'a');
        if (false === $this->file_handler) {
            throw new FileHandlerException("File {$this->filename} cant't be open to use.");
        }
        return $this;
    }

    /**
     * @param string $message
     * @param array $data
     * @return bool
     */
    public function write(string $message, array $data = []): bool
    {
        $append = $message . PHP_EOL;
        flock($this->file_handler, LOCK_EX);
        fwrite($this->file_handler, $append);
        flock($this->file_handler, LOCK_UN);
        fclose($this->file_handler);

        return true;
    }
}