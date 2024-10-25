<?php

/**
 * @var ContainerInterface $container
 * @var Config $config
 * @var Command $command
 */

use App\Support\Config;
use App\Support\Console\Command;
use App\Support\Console\Input;
use Psr\Container\ContainerInterface;
use App\Support\Console\Output;

require __DIR__.'/config/bootstrap.php';

$config = $container->get(Config::class);
$commands = $config('console.commands');
$output = new Output();

if (!isset($argv[1])) {
    if (empty($commands)) {
        $output->warning('No registered commands!');
    } else {
        $output->info('Command list:');

        foreach ($commands as $alias => $class) {
            $output->writeln('- ' . $alias . PHP_EOL);
        }
    }
    exit();
}

$name = $argv[1];

if (!array_key_exists($name, $commands)) {
    $output->error('Command not found: ' . $name);
}

$input = new Input(array_slice($argv, 2));

$command = $container->get($commands[$name]);
$command->execute($input, $output);