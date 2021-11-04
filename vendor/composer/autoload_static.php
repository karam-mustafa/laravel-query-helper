<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita50cd7522844c38cf5d20c613e3db54c
{
    public static $prefixLengthsPsr4 = array (
        'K' => 
        array (
            'KMLaravel\\QueryHelper\\' => 22,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'KMLaravel\\QueryHelper\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita50cd7522844c38cf5d20c613e3db54c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita50cd7522844c38cf5d20c613e3db54c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita50cd7522844c38cf5d20c613e3db54c::$classMap;

        }, null, ClassLoader::class);
    }
}
