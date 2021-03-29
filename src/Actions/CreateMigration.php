<?php


namespace Helixar\Laraconsole\Actions;


use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateMigration extends Command
{
    /**
     * @var string $signature
     */
    protected $signature = 'laraconsole:migration {name}';

    /**
     * @var string $description
     */
    protected $description = 'Create a crud';

    /**
     * @var string $type
     */
    protected $type = 'Laraconsole';

    public function handle(): int
    {
        $name = $this->argument('name');
        $migration = "create_" . Str::snake(Str::pluralStudly(class_basename($name))) .  "_table";
        try {
            $this->call('make:migration', [
                'name' => $migration,
                '--create' => $name,
            ]);
        } catch (\InvalidArgumentException $exception) {
            $this->error($exception->getMessage());
        }
        return 0;
    }
}
