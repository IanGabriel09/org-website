<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit18971f2041c4fc7cb8d032f36b204a16
{
    public static $prefixLengthsPsr4 = array (
        'V' => 
        array (
            'Vendor\\OrgWebsite\\' => 18,
        ),
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Vendor\\OrgWebsite\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit18971f2041c4fc7cb8d032f36b204a16::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit18971f2041c4fc7cb8d032f36b204a16::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit18971f2041c4fc7cb8d032f36b204a16::$classMap;

        }, null, ClassLoader::class);
    }
}
