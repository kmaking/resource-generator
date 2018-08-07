<?php

namespace KMAKing\ResourceGenerator\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use KMAKing\ResourceGenerator\Traits\{Generator, Path};

class UrlPresenterGenerator extends Command
{
    use Generator, Path;

    protected $hidden = true;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kma-gen:url-presenter {name : Generate url presenter file}
                            { --model-name= : Give Model Name}
                            { --model-path= : Give Model path}
                            { --action-name= : Give Action Name}
                            { --route-action-name= : Give Route Name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command generate url presenter file for model';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');

        $option = [];
        $option['model_name'] = $this->option('model-name');
        $option['model_path'] = $this->option('model-path');
        $option['action_name'] = $this->option('action-name');
        $option['route_action_name'] = $this->option('route-action-name');

        $url_presenter_path = $this->getUrlPresenterPath();
        $this->generateDirectory($url_presenter_path);

        $this->info("\nUrl Presenter Generator");
        $this->info("=============================");

        $skeleton_path = $this->getSkeletonPath('url_presenter');
        $url_presenter_file = $this->getUrlPresenterFile($option['model_name']);

        if(File::exists($url_presenter_file)) {
            $this->error("$url_presenter_file file already exists!..");
        } else {
            $this->generateFile($skeleton_path, $url_presenter_file, $option);
            $this->info("$url_presenter_file Generate successfully!..");
        }
    }

}
