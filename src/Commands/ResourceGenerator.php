<?php

namespace KMAKing\ResourceGenerator\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use KMAKing\ResourceGenerator\Traits\{Generator, Path};

class ResourceGenerator extends Command
{
    use Generator, Path;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kma-gen:resources {model : Give model name}
                            {--layout=layout.app : Give blade file layout}
                            {--view-path=<ModelName> : Give view file path}
                            {--prefix=<ModelName> : Give route prefix name}
                            {--namespace=App\Http\Controllers : Give namespace for you controller}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate resources for CRUD operation.';

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
        $this->model_path = $this->argument('model');
        $this->model_path = str_replace("/", "\\", $this->model_path);
        
        $model_array = explode("/", $this->model_path);
        $this->model_name = $model_array[sizeof($model_array) - 1];

        $this->layout_name = $this->option('layout') ?? "layout.app";

        $this->view_path = $this->option('view-path');

        $this->route_action_name = $this->option('prefix');

        $this->controller_namespace = $this->option('namespace');
        
        $this->generateTerms();

        /**
         * Call Controller Generator function
         */
        $this->callControllerGenerator();
        $this->info(Artisan::output());

        /**
         * Call View Generator function
         */
        $this->callViewGenerator();
        $this->info(Artisan::output());

        /**
         * Call Url Presenter Generator function
         */
        $this->callUrlPresenterGenerator();
        $this->info(Artisan::output());


    }

    private function callControllerGenerator()
    {
        Artisan::call('kma-gen:controller', [
            'name' => sprintf("%sController", $this->model_name),
            '--namespace' => $this->controller_namespace,
            '--model-name' => $this->model_name,
            '--model-path' => $this->model_path,
            '--use-controller' => $this->use_base_controller,
            '--action-name' => $this->action_name,
            '--action-name-p' => $this->action_name_p,
            '--view-path' => $this->view_path,
        ]);
    }

    private function callViewGenerator()
    {
        Artisan::call('kma-gen:view', [
            'name' => $this->action_name,
            '--layout' => $this->layout_name,
            '--model-name' => $this->model_name,
            '--model-name-p' => $this->model_name_p,
            '--action-name' => $this->action_name,
            '--action-name-p' => $this->action_name_p,
            '--view-path' => $this->view_path,
            '--route-action-name' => $this->route_action_name,
        ]);
    }

    private function callUrlPresenterGenerator()
    {
        Artisan::call('kma-gen:url-presenter', [
            'name' => $this->action_name,
            '--model-name' => $this->model_name,
            '--model-path' => $this->model_path,
            '--action-name' => $this->action_name,
            '--route-action-name' => $this->route_action_name,
        ]);
    }
}