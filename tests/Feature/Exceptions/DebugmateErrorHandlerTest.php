<?php

namespace Debugmate\Tests\Feature\Exceptions;

use Debugmate\Common\OccurrenceType;
use Debugmate\Exceptions\DebugmateErrorHandler;
use Debugmate\Tests\Fixtures\Exceptions\MyException;
use Debugmate\Tests\TestCase;
use Mockery;
use GuzzleHttp\Client;

class DebugmateErrorHandlerTest extends TestCase
{
    /** @test */
    public function it_should_send_error_to_debugmate_serve()
    {
        putenv('DEBUGMATE_DOMAIN=http://debugmate');

        $debugmateUrl = 'http://debugmate/webhook';

        Mockery::mock('overload:' . Client::class)
            ->shouldReceive('post')
            ->withArgs(function ($uri) use ($debugmateUrl) {
                return $uri == $debugmateUrl;
            })->times(1);

        (new DebugmateErrorHandler())->log(new MyException());
    }

    /** @test */
    public function it_should_send_error_to_debugmate_serve_without_url()
    {
        global $consoleFakeReturn;

        $consoleFakeReturn = true;
        Mockery::mock('overload:' . Client::class)
            ->shouldReceive('post');

        $data = (new DebugmateErrorHandler())->log(new MyException());
        $this->assertNull($data['url']);
    }

    /** @test */
    public function it_should_send_error_to_debugmate_with_type_cli()
    {
        global $consoleFakeReturn;

        $consoleFakeReturn = true;
        Mockery::mock('overload:' . Client::class)
            ->shouldReceive('post');

        $data = (new DebugmateErrorHandler())->log(new MyException());
        $this->assertSame($data['type'], OccurrenceType::CLI);
    }
}
