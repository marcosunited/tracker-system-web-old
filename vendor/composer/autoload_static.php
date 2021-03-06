<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4cddadd7bcaaf09d96167da6f356305a
{
    public static $prefixLengthsPsr4 = array (
        'a' => 
        array (
            'apimatic\\jsonmapper\\' => 20,
        ),
        'C' => 
        array (
            'ClickSendLib\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'apimatic\\jsonmapper\\' => 
        array (
            0 => __DIR__ . '/..' . '/apimatic/jsonmapper/src',
        ),
        'ClickSendLib\\' => 
        array (
            0 => __DIR__ . '/..' . '/clicksend/clicksend-php/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'U' => 
        array (
            'Unirest\\' => 
            array (
                0 => __DIR__ . '/..' . '/mashape/unirest-php/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4cddadd7bcaaf09d96167da6f356305a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4cddadd7bcaaf09d96167da6f356305a::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit4cddadd7bcaaf09d96167da6f356305a::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
