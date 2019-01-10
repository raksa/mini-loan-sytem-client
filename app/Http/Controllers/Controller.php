<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\Factory as ViewFactory;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
    }

    /**
     * Get module dir
     *
     * @return string
     */
    private function getModuleDir()
    {
        $controllerClass = \get_class($this);
        $reflector = new \ReflectionClass($controllerClass);
        $fileName = $reflector->getFileName();
        $dirName = File::dirname($fileName);
        return $dirName;
    }

    /**
     * View name to full path helper
     *
     * @param string $viewName
     * @return string
     */
    private function toViewFullPath($viewName)
    {
        $ds = DIRECTORY_SEPARATOR;
        $moduleDir = $this->getModuleDir();
        $viewPath = $moduleDir . $ds . 'views' . $ds . $viewName . '.blade.php';
        return $viewPath;
    }

    /**
     * Get model class
     *
     * @return string
     */
    private function getModelClass()
    {
        $controllerClass = \get_class($this);
        $nameSpace = \substr($controllerClass, 0, \strrpos($controllerClass, '\\'));
        $modelClass = $nameSpace . \substr($nameSpace, \strrpos($nameSpace, '\\'));
        return $modelClass;
    }

    /**
     * Get model class
     *
     * @return string
     */
    private function getRouteBaseName()
    {
        $controllerClass = \get_class($this);
        $nameSpace = \substr($controllerClass, 0, \strrpos($controllerClass, '\\'));
        $moduleName = \substr($nameSpace, \strrpos($nameSpace, '\\') + 1);
        return \strtolower($moduleName) . 's';
    }

    /**
     *
     * @param type $path
     * @return string
     */

    public function view($viewName, $data = [], $mergeData = [])
    {
        $viewPath = $this->toViewFullPath($viewName);
        $factory = app(ViewFactory::class);
        $mergeData['modelClass'] = $this->getModelClass();
        return $factory->file($viewPath, $data, $mergeData);
    }
}
