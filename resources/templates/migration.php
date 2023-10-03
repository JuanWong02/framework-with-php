<?php

use Jc\Database\DB;
use Jc\Database\Migrations\Migration;

return new class () implements Migration {
    public function up() {
        DB::statement('$UP');
    }

    public function down() {
        DB::statement('$DOWN');
    }
};