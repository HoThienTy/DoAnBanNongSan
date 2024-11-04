<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb990c525905eb665ceed4c232f0c0cad
{
    public static $prefixLengthsPsr4 = array (
        'I' => 
        array (
            'Intervention\\Image\\' => 19,
            'Intervention\\Gif\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Intervention\\Image\\' => 
        array (
            0 => __DIR__ . '/..' . '/intervention/image/src',
        ),
        'Intervention\\Gif\\' => 
        array (
            0 => __DIR__ . '/..' . '/intervention/gif/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb990c525905eb665ceed4c232f0c0cad::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb990c525905eb665ceed4c232f0c0cad::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb990c525905eb665ceed4c232f0c0cad::$classMap;

        }, null, ClassLoader::class);
    }
}