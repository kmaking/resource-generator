<?php

namespace KMAKing\ResourceGenerator\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use KMAKing\ResourceGenerator\Traits\Generator;
use KMAKing\ResourceGenerator\Traits\Path;

class ViewGenerator extends Command
{
    use Generator, Path;

    protected $hidden = true;
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kma-gen:view {name : All view files generate under given name}
                            { --layout= : Give layout name}
                            { --model-name= : Give Model Name}
                            { --model-name-p= : Give Model Plural Name}
                            { --action-name= : Give Action Name}
                            { --action-name-p= : Give Plural Action Name}
                            { --view-path= : Specify view path if you want to change default path }
                            { --route-action-name= : Give Route Name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command generate views (create, edit, form, index and show)';

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
        $option['layout_name'] = $this->option('layout');
        $option['model_name'] = $this->option('model-name');
        $option['model_name_p'] = $this->option('model-name-p');

        $option['action_name'] = $this->option('action-name');
        $option['action_name_p'] = $this->option('action-name-p');
        
        $option['view_path'] = $this->option('view-path');

        $option['route_action_name'] = $this->option('route-action-name');

        // $this->info(json_encode($option));

        $view_path = $this->getViewPath($option['view_path']);
        $this->generateDirectory($view_path);

        $this->info("\nResource View File Generator");
        $this->info("=============================");

        foreach (['index', 'form', 'create', 'edit', 'show'] as $file) {
            
            $skeleton_path = $this->getSkeletonPath($file);
            $blade_path = $this->getViewFile($option['view_path'], $file);

            if(File::exists($blade_path)) {
                $this->error("$blade_path file already exists!..");
            } else {
                $this->generateFile($skeleton_path, $blade_path, $option);
                $this->info("$blade_path Generate successfully!..");
            }

        }

    }

}
