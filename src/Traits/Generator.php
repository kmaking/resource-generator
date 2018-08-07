<?php

namespace KMAKing\ResourceGenerator\Traits;

use Illuminate\Support\Facades\File;

trait Generator {

	/**
	 * @var $layout_name
	 */
	protected $layout_name;

	/**
	 * @var $view_path
	 */
	protected $view_path;

	/**
	 * @var $model_path
	 */
	protected $model_path;

	/**
	 * @var $model_name
	 */
	protected $model_name;

	/**
	 * @var $model_name_p
	 */
	protected $model_name_p;

	/**
	 * @var $action_name
	 */
	protected $action_name;

	/**
	 * @var $action_name_p
	 */
	protected $action_name_p;

	/**
	 * @var $route_action_name
	 */
	protected $route_action_name;

	/**
	 * @var $use_base_controller
	 */
	protected $use_base_controller;

	/**
	 * @var $controller_namespace
	 */
	protected $controller_namespace;

	/**
	 * @var $search_term 
	 */
	protected $search_term = [
		'layout_name' => '[=|LayoutName|=]',
		'view_path' => '[=|ViewPath|=]',
		'model_path' => '[=|ModelPath|=]',
		'model_name' => '[=|ModelName|=]',
		'model_name_p' => '[=|ModelNameP|=]',
		'action_name' => '[=|ActionName|=]',
		'action_name_p' => '[=|ActionNameP|=]',
		'route_action_name' => '[=|RouteActionName|=]',
		'use_base_controller' => '[=|UseBaseController|=]',
		'controller_namespace' => '[=|ControllerNamespace|=]'
	];

	/**
	 * @var $replace_term 
	 */
	protected $replace_term;
	
	/**
	 * Generate Terms for file to replce and generate files
	 */
	protected function generateTerms()
	{
		$this->model_name = class_basename($this->model_path);
		$this->model_name_p = str_plural($this->model_name);
		
		$this->action_name = snake_case($this->model_name);
		$this->action_name_p = str_plural($this->action_name);
		
		$this->view_path = $this->view_path=="<ModelName>"? $this->action_name: $this->view_path;
		$this->route_action_name = $this->route_action_name=="<ModelName>"? $this->action_name: $this->route_action_name;

		if($this->controller_namespace=="App\\Http\\Controllers") {
			$this->use_base_controller = "";
		} else {
			$this->use_base_controller = "use App\\Http\\Controllers\\Controller;";
		}
	}

	/**
	 * Generate file from skeleton content
	 * This function get skeleton and replace terms and generate file
	 *
	 * @param $skeletin_path
	 * @param $file_path
	 */
	protected function generateFile($skeleton_path, $file_path, $replace_term)
	{
		if (isset($replace_term['namespace'])) {
			$replace_term['controller_namespace'] = $replace_term['namespace'];
			unset($replace_term['namespace']);
		}

		$search_term = $replace_term;

		foreach($this->search_term as $key => $value) {
			if(array_key_exists($key, $search_term))
				$search_term[$key] = $value;
		}
		
		$skeleton_content = File::get($skeleton_path);
		$output = str_replace(
			$search_term,
			$replace_term,
			$skeleton_content
		);
		File::put($file_path, $output);	
	}
}