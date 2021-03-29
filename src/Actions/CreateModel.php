<?php


namespace Helixar\Laraconsole\Actions;

use Illuminate\Foundation\Console\ModelMakeCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class CreateModel extends ModelMakeCommand
{

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__. '/../stubs/model.stub';
    }
}
