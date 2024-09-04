<?php

namespace Debugmate\Tests\Feature;

use Debugmate\Debugmate;
use Debugmate\Tests\TestCase;

class DebugmateTest extends TestCase
{
    /** @test */
    public function it_should_add_the_custom_environments()
    {
        Debugmate::addCustomEnvs(['new-env' => 'custom-env']);

        $payload = Debugmate::getCustomEnvs();

        $this->assertEquals($payload['new-env'], 'custom-env');
    }

    /** @test */
    public function it_should_add_the_custom_environments_with_closure()
    {
        Debugmate::addCustomEnvs(function () {
            return ['new-env' => 'custom-env'];
        });

        $payload = Debugmate::getCustomEnvs();

        $this->assertEquals($payload['new-env'], 'custom-env');
    }

    /** @test */
    public function it_should_return_the_null_user_when_closure_is_null()
    {
        $user = Debugmate::getUser();

        $this->assertNull($user);
    }

    /** @test */
    public function it_should_return_the_user_without_guard()
    {
        $data = ['name' => 'debugmate', 'email' => 'fake@email.com'];

        Debugmate::setUser(function () use ($data) {
            return $data;
        });

        $user = Debugmate::getUser();

        $this->assertArrayContains($user->toArray(), $data);
    }

    /** @test */
    public function it_should_return_the_user_with_guard()
    {
        $data = ['name' => 'debugmate', 'email' => 'fake@email.com'];

        Debugmate::setUser(function () use ($data) {
            return $data;
        }, 'test');

        $user = Debugmate::getUser();

        $this->assertArrayContains($user->toArray(), array_merge($data, ['guard' => 'test']));
    }

    /** @test */
    public function it_should_return_the_null_user_when_data_is_not_array()
    {
        Debugmate::setUser(function () {
            return 'debugmate-user';
        });

        $user = Debugmate::getUser();

        $this->assertNull($user);
    }

    /** @test */
    public function it_should_return_the_framework_version()
    {
        $vesrion = 'V' . rand(1, 5);

        Debugmate::frameworkVersion($vesrion);

        $this->assertSame($vesrion, Debugmate::$frameworkVersion);
    }
}
