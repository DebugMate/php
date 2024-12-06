<?php

namespace Debugmate\Exceptions;

use Debugmate\Exceptions\DebugmateErrorHandler;
use Symfony\Component\ErrorHandler\ErrorHandler;
use Symfony\Component\Dotenv\Dotenv;
use Debugmate\Context\DumpContext;
use Throwable;

class Handler
{
    protected $handleClosure;

    public static function register($handleClosure = null)
    {
        $handler = new self();
        $handler->setHandleClosure($handleClosure);

        $handler->registerHandlers();
    }

    public function setHandleClosure($handleClosure)
    {
        $this->handleClosure = $handleClosure;

        return $this;
    }

    public function registerHandlers()
    {
        (new DumpContext())->start();

        if (file_exists('.env')) {
            (new Dotenv)->usePutenv()->load('.env');
        }

        $handler = ErrorHandler::register();
        $handler->setExceptionHandler([$this, 'exceptionHandler']);
    }

    public function exceptionHandler(Throwable $throwable)
    {
        (new DebugmateErrorHandler())->log($throwable);

        if ($this->handleClosure) {
            try {
                call_user_func($this->handleClosure, $throwable);
            } catch (Throwable $throwable) {
                (new DebugmateErrorHandler())->log($throwable);
            }
        }
    }
}