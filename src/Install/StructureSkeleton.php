<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Flarum\Install;
use Flarum\Foundation\Console\CacheClearCommand;

class StructureSkeleton
{
    private static $publicPaths = [
        '/public/assets' => '/assets',
        '/public/.htaccess.shared' => '/.htaccess',
        '/public/index.php.shared' => '/index.php'
    ];

    private static function compat($strict = true)
    {
        $compatDir = __DIR__.'/../../stubs/skeleton_compat';
        $appDir = getcwd();
        $compatPaths = [
            $compatDir.'/site.php' => $appDir.'/site.php',
            $compatDir.'/site.php.shared' => $appDir.'/site.php.shared',
            $compatDir.'/.nginx.conf' => $appDir.'/.nginx.conf',
            $compatDir.'/.nginx.conf.shared' => $appDir.'/.nginx.conf.shared',
            $compatDir.'/index.php' => $appDir.'/public/index.php',
            $compatDir.'/index.php.shared' => $appDir.'/public/index.php.shared',
            $compatDir.'/.htaccess' => $appDir.'/public/.htaccess',
            $compatDir.'/.htaccess.shared' => $appDir.'/public/.htaccess.shared',
        ];

        foreach ($compatPaths as $compatPath => $appPath) {
            if (!file_exists($appPath) or ($strict and md5_file($compatPath) != md5_file($appPath))) {
                copy($compatPath, $appPath);
            }
        }
    }

    public static function enableShared()
    {
        self::compat(false);
        $root = getcwd();
        // If shared hosting optimized, don't use public folder
        if (! file_exists($root.'/assets')) {
            // Move files out of public folder
            foreach (self::$publicPaths as $dedicatedPath => $sharedPath) {
                exec('mv -f '.$root.$dedicatedPath.' '.$root.$sharedPath);
            }
            rename($root.'/site.php', $root.'/site.php.nonshared');
            rename($root.'/site.php.shared', $root.'/site.php');
            rename($root.'/.nginx.conf', $root.'/.nginx.conf.nonshared');
            rename($root.'/.nginx.conf.shared', $root.'/.nginx.conf');

            return 'Restructured into shared hosting mode.';
        } else {
            return 'Already in shared hosting mode.';
        }
    }

    public static function disableShared()
    {
        self::compat(false);
        $root = getcwd();
        // If shared hosting not optimized use public folder
        if (file_exists($root.'/assets')) {
            foreach (self::$publicPaths as $dedicatedPath => $sharedPath) {
                exec('mv -f '.$root.$sharedPath.' '.$root.$dedicatedPath);
            }
            rename($root.'/site.php', $root.'/site.php.shared');
            rename($root.'/site.php.nonshared', $root.'/site.php');
            rename($root.'/.nginx.conf', $root.'/.nginx.conf.shared');
            rename($root.'/.nginx.conf.nonshared', $root.'/.nginx.conf');

            return 'Restructured out of shared hosting mode.';
        } else {
            return 'Already not in shared hosting mode.';
        }
    }
}
