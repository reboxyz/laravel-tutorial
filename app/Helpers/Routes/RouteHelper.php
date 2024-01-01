<?php 

namespace App\Helpers\Routes;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class RouteHelper 
{
    public static function includeRouteFiles(string $folder)
    {
        // iterate the v1 folder recursively and require the file in each iteration
        $dirIterator = new RecursiveDirectoryIterator($folder);
        $it = new RecursiveIteratorIterator($dirIterator);

        /** @var RecursiveDirectoryIterator | RecursiveIteratorIterator $it */
        while ($it->valid()) {
            if (!$it->isDot() 
                && $it->isFile() 
                && $it->isReadable() 
                && $it->current()->getExtension() === 'php') 
            {
                require $it->key();
                //require $it->current()->getPathname(); // Note! This is also OK
            }
            $it->next();
        }

    }
}

?>