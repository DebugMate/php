<?php

namespace Debugmate\Context;

use Debugmate\Debugmate;
use Debugmate\Interfaces\ContextInterface;

class UserContext implements ContextInterface
{
    protected $user;

    public function __construct()
    {
        $this->user = Debugmate::getUser();
    }

    public function getContext(): array
    {
        if (running_in_console() || !$this->user) {
            return [];
        }

        return $this->user->toArray();
    }
}
