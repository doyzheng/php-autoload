<?php

namespace doyzheng\autoload;

/**
 * Class Psr4
 * @package doyzheng\Autoload
 */
class Psr4
{
    
    /**
     * @param $namespace mixed 命名空间
     * @param $dir       string 根命名空间目录
     */
    public static function register($namespace, $dir = '')
    {
        $config = [];
        if (is_string($namespace) && is_string($dir)) {
            $config[$namespace] = $dir;
        } else if (is_array($namespace)) {
            $config = $namespace;
        }
        // 支持批量注册
        foreach ($config as $namespace => $dir) {
            spl_autoload_register(function ($class) use ($namespace, $dir) {
                $pattern = '/^' . $namespace . '\\\(.*)/';
                // 匹配类名,计算文件名
                preg_match($pattern, $class, $matches);
                if (isset($matches[1])) {
                    $filename = $dir . '/' . $matches[1] . '.php';
                    if (is_file($filename)) {
                        include_once $filename;
                    }
                }
            });
        }
    }
    
}

