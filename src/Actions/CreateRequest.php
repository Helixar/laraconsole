<?php


namespace Helixar\Laraconsole\Actions;

use Illuminate\Foundation\Console\RequestMakeCommand;

class CreateRequest extends RequestMakeCommand
{
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__ . '/../stubs/request.stub';
    }
}
