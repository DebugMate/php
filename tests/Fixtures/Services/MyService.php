<?php

namespace Debugmate\Tests\Fixtures\Services;

use Debugmate\Tests\Fixtures\Exceptions\MyException;

class MyService
{
    public function handle(): void
    {
        throw new MyException();
    }
}
