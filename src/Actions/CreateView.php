<?php


namespace Helixar\Laraconsole\Actions;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateView extends Command
{
    /**
     * @var string
     */
    protected $signature = 'laraconsole:view {name} {--layout}';

    /**
     * @var string
     */
    protected $description = 'Create a view';

    /**
     * @var string
     */
    protected $type = 'Laraconsole';

    public function handle(): int
    {
        $view = $this->argument('name');
        $layout = $this->option('layout');

        $path = $this->viewPath($view);

        $files = ['index.blade.php', 'create.blade.php', 'show.blade.php', 'edit.blade.php'];

        foreach ($files as $file) {
            $filename = $path . $file;
            $this->createDir($filename);
            if (File::exists($filename))
            {
                $this->error("File {$file} already exists!");
            }else {
                File::put($filename, "@extends('{$layout}')\n@section('content')\n\n@endsection");
                $this->info("View {$file} created successfully.");
            }
        }
        return 0;
    }

    public function viewPath($view): string
    {
        $view = str_replace('.', '/', $view . '/');

        return "resources/views/pages/{$view}";
    }

    public function createDir($path): void
    {
        $dir = dirname($path);

        if (!file_exists($dir))
        {
            File::makeDirectory($dir, 0777, true);
        }
    }

}
