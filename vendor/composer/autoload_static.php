<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc93d7c551660920c66439db4c5ecfb47
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\Models\\' => 11,
            'App\\Core\\Helpers\\' => 17,
            'App\\Core\\' => 9,
            'App\\Controllers\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\Models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/models',
        ),
        'App\\Core\\Helpers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/core/helpers',
        ),
        'App\\Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/core',
        ),
        'App\\Controllers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/Controllers',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc93d7c551660920c66439db4c5ecfb47::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc93d7c551660920c66439db4c5ecfb47::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitc93d7c551660920c66439db4c5ecfb47::$classMap;

        }, null, ClassLoader::class);
    }
}