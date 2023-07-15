<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitbecee7b5949186acf4a8bacd91e8c61e
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInitbecee7b5949186acf4a8bacd91e8c61e', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitbecee7b5949186acf4a8bacd91e8c61e', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitbecee7b5949186acf4a8bacd91e8c61e::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}