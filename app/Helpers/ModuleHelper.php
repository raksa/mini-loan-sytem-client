<?php
namespace App\Helpers;

use Illuminate\Support\Facades\File;

/*
 * Author: Raksa Eng
 */

class ModuleHelper
{
    public static function getClassFromFile($file)
    {
        $fp = fopen($file, 'r');
        $class = $namespace = $buffer = '';
        $i = 0;
        while (!$class) {
            if (feof($fp)) {
                break;
            }
            $buffer .= fread($fp, 512);
            $tokens = token_get_all($buffer);

            if (strpos($buffer, '{') === false) {
                continue;
            }

            for (; $i < count($tokens); $i++) {
                if ($tokens[$i][0] === T_NAMESPACE) {
                    for ($j = $i + 1; $j < count($tokens); $j++) {
                        if ($tokens[$j][0] === T_STRING) {
                            $namespace .= ($namespace ? '\\' : '') . $tokens[$j][1];
                        } else if ($tokens[$j] === '{' || $tokens[$j] === ';') {
                            break;
                        }
                    }
                }

                if ($tokens[$i][0] === T_CLASS) {
                    for ($j = $i + 1; $j < count($tokens); $j++) {
                        if ($tokens[$j] === '{') {
                            $class = $tokens[$i + 2][1];
                        }
                    }
                }
            }
        }
        return $class ? $namespace . '\\' . $class : null;
    }

    public static function getModuleDirs()
    {
        $componentPath = app_path() . DIRECTORY_SEPARATOR . "Components";
        if (File::isDirectory($componentPath)) {
            $components = File::directories($componentPath);
            foreach ($components as $component) {
                $modules = File::directories($component . DIRECTORY_SEPARATOR . 'Modules');
                foreach ($modules as $module) {
                    yield $module;
                }
            }
        }
    }

    public static function getModelPolicyClasses()
    {
        $modulePolicies = [];
        foreach (static::getModuleDirs() as $module) {
            $modelBaseName = File::basename($module);
            $policyFile = $module . DIRECTORY_SEPARATOR . $modelBaseName . 'Policy.php';
            $modelFile = $module . DIRECTORY_SEPARATOR . $modelBaseName . '.php';
            if (File::isFile($policyFile) && ($policyClass = static::getClassFromFile($policyFile)) &&
                File::isFile($modelFile) && ($moduleClass = static::getClassFromFile($modelFile))
            ) {
                $modulePolicies[$moduleClass] = $policyClass;
            }
        }
        return $modulePolicies;
    }

    public static function getRouteBaseNamePolicyClasses()
    {
        $routeBaseNamePolicies = [];
        foreach (static::getModuleDirs() as $module) {
            $modelBaseName = File::basename($module);
            $policyFile = $module . DIRECTORY_SEPARATOR . $modelBaseName . 'Policy.php';
            if (File::isFile($policyFile) && ($policyClass = static::getClassFromFile($policyFile))) {
                $routeBaseNamePolicies[\strtolower($modelBaseName) . 's'] = $policyClass;
            }
        }
        return $routeBaseNamePolicies;
    }
}
