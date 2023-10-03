<?php

use Jc\Database\DB;
use Jc\Database\Migrations\Migration;

return new class() implements Migration {
    public function up() {
        DB::statement('CREATE TABLE clients (id INT AUTO_INCREMENT PRIMARY KEY)');
    }

    public function down() {
        DB::statement('DROP TABLE clients');
    }
};