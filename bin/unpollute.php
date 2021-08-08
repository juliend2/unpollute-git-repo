<?php declare(strict_types=1);
// Use it like so:
// php unpollute.php directory/to/keep/clean

// Depends on:
// git version 2.30.1

if (!version_compare(PHP_VERSION, PHP_VERSION, '=')) {
    fwrite(
        STDERR,
        sprintf(
            '%s declares an invalid value for PHP_VERSION.' . PHP_EOL .
            'This breaks fundamental functionality such as version_compare().' . PHP_EOL .
            'Please use a different PHP interpreter.' . PHP_EOL,

            PHP_BINARY
        )
    );

    die(1);
}

if (version_compare('7.0.0', PHP_VERSION, '>')) {
    fwrite(
        STDERR,
        sprintf(
            'This version of Unpollute requires PHP >= 7.0.' . PHP_EOL .
            'You are using PHP %s (%s).' . PHP_EOL,
            PHP_VERSION,
            PHP_BINARY
        )
    );

    die(1);
}

if (!ini_get('date.timezone')) {
    ini_set('date.timezone', 'UTC');
}

foreach (array(__DIR__ . '/../../autoload.php', __DIR__ . '/../vendor/autoload.php', __DIR__ . '/vendor/autoload.php') as $file) {
    if (file_exists($file)) {
        define('UNPOLLUTE_COMPOSER_INSTALL', $file);

        break;
    }
}

unset($file);

if (!defined('UNPOLLUTE_COMPOSER_INSTALL')) {
    fwrite(
        STDERR,
        'You need to set up the project dependencies using Composer:' . PHP_EOL . PHP_EOL .
        '    composer install' . PHP_EOL . PHP_EOL .
        'You can learn all about Composer on https://getcomposer.org/.' . PHP_EOL
    );

    die(1);
}

require UNPOLLUTE_COMPOSER_INSTALL;

use Julien\Unpollute;

// echo __DIR__.'/../src/Unpollute.php';
// require_once(__DIR__.'/../src/GitOutputParser.php');
// require_once(__DIR__.'/../src/Unpollute.php');

$path = $argv[1];

if (! $path ) {
    die("You need to provide a path.\n\n");
}

// $git = '/usr/local/cpanel/3rdparty/lib/path-bin/git';
$git = '/usr/bin/git';

$unpolluter = new Unpollute($path, $git);
$unpolluter->execute();

// php bin/unpollute.php /home/julien/mysqlmigrator