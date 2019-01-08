<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\Factory as ViewFactory;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * View name to full path helper
     */
    private function toViewFullPath($viewName)
    {
        $dir_path = \substr(\get_class($this), 0, \strrpos(\get_class($this), '\\'));
        $get_path = \lcfirst(\str_replace("\\", DIRECTORY_SEPARATOR, $dir_path));
        $viewPath = $get_path . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $viewName . '.blade.php';
        return base_path() . DIRECTORY_SEPARATOR . $viewPath;
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
        return $factory->file($viewPath, $data, $mergeData);
    }
}
