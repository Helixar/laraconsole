<?php


namespace Helixar\Laraconsole\Actions;

use Illuminate\Routing\Console\ControllerMakeCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class CreateController extends ControllerMakeCommand
{
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__ . '/../stubs/controller.model.stub';
    }

    /**
     * Build the model replacement values.
     *
     * @param  array  $replace
     * @return array
     */
    protected function buildModelReplacements(array $replace): array
    {
        $modelClass = $this->parseModel($this->option('model'));

        if (! class_exists($modelClass)) {
            if ($this->confirm("A {$modelClass} model does not exist. Do you want to generate it?", true)) {
                $this->call('make:model', ['name' => $modelClass]);
            }
        }
        return array_merge($replace, [
            'DummyFullModelClass' => $modelClass,
            '{{ namespacedModel }}' => $modelClass,
            '{{namespacedModel}}' => $modelClass,
            'DummyModelClass' => class_basename($modelClass),
            '{{ model }}' => class_basename($modelClass),
            '{{model}}' => class_basename($modelClass),
            'DummyModelVariable' => lcfirst(class_basename($modelClass)),
            '{{ modelVariable }}' => lcfirst(class_basename($modelClass)),
            '{{modelVariable}}' => lcfirst(class_basename($modelClass)),
            '{{ formrequest }}' => class_basename($modelClass) . 'Request',
            '{{ formrequestNamespace }}' => str_replace("/", "\\", $this->option('dir')) . 'Request',
            '{{ view }}' => Str::lower(Str::pluralStudly(class_basename($modelClass))),
            '{{ modelPlural }}' => Str::lower(Str::pluralStudly(class_basename($modelClass))),
            '{{ modelSingular }}' => Str::lower(class_basename($modelClass)),
            '{{ viewDir }}' => Str::lower(Str::pluralStudly(str_replace('/', '.', $this->option('dir')))),
        ]);
    }

    protected function getOptions()
    {
        return [
            ['api', null, InputOption::VALUE_NONE, 'Exclude the create and edit methods from the controller.'],
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the controller already exists'],
            ['invokable', 'i', InputOption::VALUE_NONE, 'Generate a single method, invokable controller class.'],
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'Generate a resource controller for the given model.'],
            ['parent', 'p', InputOption::VALUE_OPTIONAL, 'Generate a nested resource controller class.'],
            ['resource', 'r', InputOption::VALUE_NONE, 'Generate a resource controller class.'],
            ['dir', 'd', InputOption::VALUE_NONE, 'get subdirectories.'],
        ];
    }
}
