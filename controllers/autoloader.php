<?php
class Autoloader
{
    public static function autoload($className)
    {
        $className = str_replace('\\', '/', $className);
        $classFile = __DIR__ . '/../class/' . $className . '.php';
        if (file_exists($classFile)) {
            require_once ($classFile);
        }
    }
}

spl_autoload_register('Autoloader::autoload');