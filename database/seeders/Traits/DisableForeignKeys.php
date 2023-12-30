<?php 

namespace Database\Seeders\Traits;

use Illuminate\Support\Facades\DB;

trait DisableForeignKeys
{
    protected function disableForeignKeys()
    {
        //DB::statement('SET FOREIGN_KEY_CHECKS=0'); // MySql 
        DB::statement("PRAGMA foreign_keys = 0");    // Sqlite
    }

    protected function enableForeignKeys()
    {
        //DB::statement('SET FOREIGN_KEY_CHECKS=1'); // MySql 
        DB::statement("PRAGMA foreign_keys = 1");    // Sqlite
    }
}

