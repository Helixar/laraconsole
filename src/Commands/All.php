<?php

namespace Helixar\Laraconsole\Commands;

use App\Models\User;
use Helixar\Laraconsole\Actions\CreateController;
use Helixar\Laraconsole\Actions\CreateFactory;
use Helixar\Laraconsole\Actions\CreateMigration;
use Helixar\Laraconsole\Actions\CreateModel;
use Helixar\Laraconsole\Actions\CreateObserver;
use Helixar\Laraconsole\Actions\CreateRequest;
use Helixar\Laraconsole\Actions\CreateSeeder;
use Helixar\Laraconsole\Actions\CreateView;
use Illuminate\Console\Command;
use Illuminate\Database\Console\Migrations\TableGuesser;
use Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Console\Helper\ProgressBar;
use function PHPUnit\Framework\matches;

class All extends Command
{
    /**
     * @var string
     */
    protected $signature = 'laraconsole:all {name}';

    /**
     * @var string
     */
    protected $description = 'Create a crud';

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
        $input = $this->argument('name');
        $layout = $this->ask('Which layout view do you want to use? i.e : layouts.admin');
        $fragments = explode('/', $input);
        $name = end($fragments);
        $plural = Str::pluralStudly($name);
        $this->info("Creating the required files...");
        $this->call(CreateModel::class, [
            'name' => $name,
        ]);
        $this->call(CreateObserver::class, [
            'name' => "{$name}Observer",
            '--model' => $name
        ]);
        $this->call(CreateMigration::class, [
            'name' => Str::snake(Str::pluralStudly($name))
        ]);
        $this->call(CreateFactory::class, [
            'name' => "{$name}Factory",
            '-m' => $name
        ]);
        $this->call(CreateSeeder::class, [
            'name' => "{$name}Seeder",
        ]);
        $this->call(CreateController::class, [
            'name' => "{$input}Controller",
            '-r' => true,
            '-m' => $name,
            '--dir' => $input,
        ]);
        $this->call(CreateRequest::class, [
            'name' => "{$input}Request",
        ]);
        $this->call(CreateView::class, [
            'name' => Str::lower(Str::pluralStudly($input)),
            '--layout' => $layout
        ]);
        $this->info('files created successfully');
        $this->info('You can use these routes in your web.php file');
        $this->table(
            ['Verb', 'Path', 'Action', 'Name'], [
                ['GET', Str::lower($input), "{$input}Controller@index", Str::lower($plural) . ".index"],
                ['GET', Str::lower($input) . "/create", "{$input}Controller@create", Str::lower($plural) . ".create"],
                ['POST', Str::lower($input), "{$input}Controller@store", Str::lower($plural) . ".store"],
                ['GET', Str::lower($input) . "/{". Str::lower($name) . "}", "{$input}Controller@show", Str::lower($plural) . ".show"],
                ['GET', Str::lower($input) . "/{". Str::lower($name) . "}/edit", "{$input}Controller@edit", Str::lower($plural) . ".edit"],
                ['PUT/PATCH', Str::lower($input) . "/{". Str::lower($name) . "}", "{$input}Controller@update", Str::lower($plural) . ".update"],
                ['DELETE', Str::lower($input) . "/{". Str::lower($name) . "}", "{$input}Controller@destroy", Str::lower($plural) . ".destroy"],
            ]
        );
        return 0;
    }
}
