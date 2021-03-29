<?php

namespace Helixar\Laraconsole\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Hash;

class Fill extends Command
{
    /**
     * @var string
     */
    protected $signature = 'laraconsole:fill {model}';

    /**
     * @var string
     */
    protected $description = 'Fill a model and save it in database';

    /**
     * @var string
     */
    protected $type = 'Laraconsole';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $input = $this->argument('model');
        try {
            $model = app("App\\Models\\$input");
            $fillable = [];
            foreach ($model->getFillable() as $attribute) {
                if ($attribute === 'password') {
                    $fillable[$attribute] = Hash::make($this->secret("fill in the $attribute field"));
                }else {
                    $fillable[$attribute] = $this->ask("fill in the $attribute field");
                }
            }
            $model::create($fillable);
            $this->info("User created");
            return 0;
        } catch (BindingResolutionException $exception) {
            $this->error($exception->getMessage());
            return 0;
        }
    }
}
