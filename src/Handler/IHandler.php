<?php

namespace Sim\Logger\Handler;


interface IHandler
{
    /**
     * @return IHandler
     */
    public function init(): IHandler;

    /**
     * @param string $message
     * @param array $data
     * @return bool
     */
    public function write(string $message, array $data = []): bool;
}