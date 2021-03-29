<?php


namespace Helixar\Laraconsole\Actions;

use Illuminate\Foundation\Console\ObserverMakeCommand;

class CreateObserver extends ObserverMakeCommand
{
    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__. '/../stubs/observer.stub';
    }
}
