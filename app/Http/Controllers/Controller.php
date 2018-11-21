<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * View name to full path helper
     */
    protected function toViewFullPath($viewName)
    {
        $dir_path = \substr(\get_class($this), 0, \strrpos(\get_class($this), '\\'));
        $get_path = \lcfirst(\str_replace("\\", ".", $dir_path));
        $viewPath = $get_path . '.views.' . $viewName;
        return $viewPath;
    }

    /**
     *
     * @param type $path
     * @return string
     */

    public function view($path)
    {
        $dir_path = \substr(\get_class($this), 0, \strrpos(\get_class($this), '\\'));
        $get_path = \lcfirst(\str_replace("\\", ".", $dir_path));
        return view($get_path . '.views.' . $path);
    }
}
