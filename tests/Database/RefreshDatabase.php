<?php

namespace Jc\Tests\Database;

use Jc\Database\Drivers\DatabaseDriver;
use Jc\Database\Drivers\PdoDriver;
use Jc\Database\Model;
use PDOException;

trait RefreshDatabase {
    protected function setUp(): void {
        if (is_null($this->driver)) {
            $this->driver = singleton(DatabaseDriver::class, PdoDriver::class);
            Model::setDatabaseDriver($this->driver);
            try {
                $this->driver->connect('mysql', 'localhost', 3306, 'jc_framework_tests', 'root', '');
            } catch (PDOException $e) {
                $this->markTestSkipped("Can't connect to test database: {$e->getMessage()}");
            }
        }
    }

    protected function tearDown(): void {
        $this->driver->statement("DROP DATABASE IF EXISTS jc_framework_tests");
        $this->driver->statement("CREATE DATABASE jc_framework_tests");
    }
}













































































































































































