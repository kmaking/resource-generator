<?php

namespace KMAKing\ResourceGenerator\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use KMAKing\ResourceGenerator\Traits\{Generator, Path};

class ControllerGenerator extends Command
{
    use Generator, Path;

    protected $hidden = true;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kma-gen:controller {name : Generate controller file}
                            {--namespace= : Give Controller namespace}
                            {--model-name= : Give Model name}
                            {--model-path= : Give Model path}
                            {--use-controller= : Use controller statement require}
                            {--action-name= : Give Action Name}
                            {--action-name-p= : Give Action Name in Plural}
                            {--view-path= : Give View Path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command generate controller file';

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
        $option['namespace'] = $this->option('namespace');
        $option['model_name'] = $this->option('model-name');
        $option['model_path'] = $this->option('model-path');
        $option['use_base_controller'] = $this->option('use-controller');
        $option['action_name'] = $this->option('action-name');
        $option['action_name_p'] = $this->option('action-name-p');
        $option['view_path'] = $this->option('view-path');
        $skeleton_path = $this->getSkeletonPath('controller');
        $controller_file = $this->getControllerFile($name, $option['namespace']);

        $this->generateDirectory($this->getControllerPath($option['namespace']));

        if(File::exists($controller_file)) {
            // !$this->confirm("The [$controller_file] controller already exists. Do you want to replace it?") 
            //     ? exit
            //     : $this->info('Controller Re-Generating Successfully!...');

            $message = "$controller_file Re-Generating Successfully!...";
        }
    
        $this->generateFile($skeleton_path, $controller_file, $option);

        $this->info("\nController Generator Generator");
        $this->info("=============================");
        
        $this->info($message ?? "$controller_file Generated Successfully!...");
    }

}
