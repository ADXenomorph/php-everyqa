<?php

require __DIR__ . '/../vendor/autoload.php';

use EveryQACli\Command;
use EveryQACli\EveryQAApi\EveryQA;
use Symfony\Component\Console\Application;
use GuzzleHttp\Client;
use EveryQA\Client\Configuration;

function requireEnv(string $name)
{
    $val = getenv($name);
    if (!$val) {
        die(sprintf("%s env is not set\n", $name));
    }
    return $val;
}

$token = requireEnv('TOKEN');

$everyQa = new EveryQA(
    Configuration::getDefaultConfiguration()->setApiKey('Authorization', "Bearer " . $token),
    new Client()
);

$application = new Application();
$application->addCommands([
    new Command\GetCurrentUserCommand($everyQa),
    new Command\GetCasesCommand($everyQa),
    new Command\GetRunsCommand($everyQa),
    new Command\CreateRunCommand($everyQa),
    new Command\CloseRunCommand($everyQa),
    new Command\CreateTestCommand($everyQa),
    new Command\CreateTestActionCommand($everyQa),
]);

$application->run();

