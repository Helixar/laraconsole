<?php


namespace Helixar\Laraconsole\Actions;

use Illuminate\Database\Console\Factories\FactoryMakeCommand;

class CreateFactory extends FactoryMakeCommand
{
    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__. '/../stubs/factory.stub';
    }
}
