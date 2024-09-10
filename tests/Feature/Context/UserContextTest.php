<?php

namespace Debugmate\Tests\Unit\Context;

use Debugmate\Debugmate;
use Debugmate\Context\UserContext;
use Debugmate\Tests\TestCase;

class UserContextTest extends TestCase
{
    /** @test */
    public function it_should_retrieve_an_empty_array_if_user_is_unauthenticated()
    {
        $context = (new UserContext())->getContext();

        $this->assertEmpty($context);
    }

    /** @test */
    public function it_should_retrieve_an_user_array_if_user_is_set_on_debugmate_closure()
    {
        $user = [
            'id'    => 1,
            'name'  => 'debugmate user',
            'email' => 'fake@email.com',
            'guard' => 'web'
        ];

        Debugmate::setUser(function () use ($user) {
            return $user;
        }, 'web');

        $context = (new UserContext())->getContext();
        $this->assertEquals($user, $context);

        Debugmate::setUser(function() { return null; });
    }
}
