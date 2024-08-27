<?php

namespace App\Services;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class LoggerService
{
    private Logger $logger;

    public function __construct()
    {
        $this->logger = new Logger("dev23");
        $stream_handler = new StreamHandler("php://stdout");
        $this->logger->pushHandler($stream_handler);
    }

    public function info(string $message, array $data = []): void
    {
        $this->logger->info($message, $data);
    }
}