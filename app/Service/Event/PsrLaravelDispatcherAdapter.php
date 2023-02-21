<?php

namespace App\Service\Event;

use Illuminate\Contracts\Events\Dispatcher;
use Psr\EventDispatcher\EventDispatcherInterface;

class PsrLaravelDispatcherAdapter implements EventDispatcherInterface
{
    public function __construct(
        private Dispatcher $dispatcher,
    ) {
        //
    }

    public function dispatch(object $event)
    {
        $this->dispatcher->dispatch($event);
    }
}
