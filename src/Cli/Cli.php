<?php

namespace Jc\Cli;

use Dotenv\Dotenv;
use Jc\App;
use Jc\Cli\Commands\MakeController;
use Jc\Cli\Commands\MakeMigration;
use Jc\Cli\Commands\MakeModel;
use Jc\Cli\Commands\Migrate;
use Jc\Cli\Commands\MigrateRollback;
use Jc\Cli\Commands\Serve;
use Jc\Config\Config;
use Jc\Database\Drivers\DatabaseDriver;
use Jc\Database\Migrations\Migrator;
use Symfony\Component\Console\Application;

class Cli
{
    public static function bootstrap(string $root): self
    {
        App::$root = $root;
        Dotenv::createImmutable($root)->load();
        Config::load($root . "/config");

        foreach (config("providers.cli") as $provider) {
            (new $provider)->registerServices();
        }

        app(DatabaseDriver::class)->connect(
            config("database.connection"),
            config("database.host"),
            config("database.port"),
            config("database.database"),
            config("database.username"),
            config("database.password"),
        );

        singleton(
            Migrator::class,
            fn () => new Migrator(
                "$root/database/migrations",
                resourcesDirectory() . "/templates",
                app(DatabaseDriver::class)
            )
        );

        return new self();
    }

    public function run() {
        $cli = new Application("Jc");

        $cli->addCommands([
            new MakeMigration(),
            new Migrate(),
            new MigrateRollback(),
            new MakeModel(),
            new MakeController(),
            new Serve(),
        ]);

        $cli->run();
    }
}
