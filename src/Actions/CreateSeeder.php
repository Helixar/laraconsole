<?php


namespace Helixar\Laraconsole\Actions;

use Illuminate\Database\Console\Seeds\SeederMakeCommand;

class CreateSeeder extends SeederMakeCommand
{
    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__. '/../stubs/seeder.stub';
    }
}
