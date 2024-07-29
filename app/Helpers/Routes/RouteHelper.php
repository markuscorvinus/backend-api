<?php

namespace App\Helpers\Routes;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class RouteHelper
{
    public static function requireDirectory(string $folderDirectory): void
    {
        $dirIterator = new \RecursiveDirectoryIterator($folderDirectory);

        /** @var \RecursiveDirectoryIterator | \RecursiveIteratorIterator $it */
        $it = new \RecursiveIteratorIterator($dirIterator);
        while ($it->valid()) {
            if (
                !$it->isDot()
                && $it->isFile() && $it->isReadable()
                && $it->current()->getExtension() === 'php'
            ) {
                require $it->key(); //alternative $it->current()->getPathname();
            }
            $it->next();
        }
    }
}
