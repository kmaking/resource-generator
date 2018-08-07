<?php

namespace KMAKing\ResourceGenerator\Traits;

trait Path {

	/**
	 * Get Skeleton Path from package
	 *
	 * @param $name
	 */
	protected function getSkeletonPath($name)
	{
		return str_finish(
			str_before(__DIR__, '/Traits'),
			sprintf("/skeleton/%s.skeleton", $name)
		);
	}

	/**
	 * Check if directory exists if not generate it.
	 *
	 * @param $path
	 * @return true | false
	 */
	protected function generateDirectory($path)
	{
		if (is_dir($path)) return true;
	    $prev_path = substr($path, 0, strrpos($path, '/', -2) + 1 );
	    $return = $this->generateDirectory($prev_path);
	    return ($return && is_writable($prev_path)) ? mkdir(str_replace("\\", "", $path)) : false;
	}

	/**
	 * Get Controller file full path
	 *
	 * @param $name
	 * @param $namespace
	 * @return String
	 */
	protected function getControllerFile($name, $namespace, $extention = "php")
	{
		return str_finish(
			$this->getControllerPath($namespace),
        	sprintf('/%s.%s', $name, $extention)
		);
	}

	/**
	 * Get Controller path
	 *
	 * @param $namespace
	 * @return String
	 */
	protected function getControllerPath($namespace)
	{
		return app_path(
            sprintf('Http/Controllers/%s', str_after($namespace, 'App\\Http\\Controllers'))
		);
	}

	/**
	 * Get Url Presenter file full path
	 *
	 * @param $name
	 * @return String
	 */
	protected function getUrlPresenterFile($name)
	{
		return str_finish(
			$this->getUrlPresenterPath(),
        	sprintf('/%sUrlPresenter.php', $name)
		);
	}

	/**
	 * Get Url Presenter path
	 *
	 * @return String
	 */
	protected function getUrlPresenterPath()
	{
		return app_path('UrlPresenters');
	}

	/**
	 * Get View file full path
	 *
	 * @param $name
	 * @param $file_name
	 * @return String
	 */
	protected function getViewFile($name, $file_name)
	{
		return str_finish(
			$this->getViewPath($name),
        	sprintf('/%s.blade.php', $file_name)
		);
	}

	/**
	 * Get Url Presenter path
	 *
	 * @param $name
	 * @return String
	 */
	protected function getViewPath($name)
	{
		return resource_path('views/' . str_replace(".", "/", $name));
	}
}