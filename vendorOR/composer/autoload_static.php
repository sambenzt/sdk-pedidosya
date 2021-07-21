<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit40d966a9072beb376daa982928da9315
{
    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'Root\\Www\\' => 9,
            'ReceptionSDK\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Root\\Www\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'ReceptionSDK\\' => 
        array (
            0 => __DIR__ . '/..' . '/ReceptionSDK',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit40d966a9072beb376daa982928da9315::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit40d966a9072beb376daa982928da9315::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit40d966a9072beb376daa982928da9315::$classMap;

        }, null, ClassLoader::class);
    }
}