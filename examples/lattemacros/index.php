<?php declare(strict_types = 1);

namespace NextrasDemos\FormsRendering\LatteMacros;

use Nette\Application\Application;
use Nette\Bootstrap\Configurator;

require_once __DIR__ . '/../../vendor/autoload.php';


$configurator = new Configurator;
$configurator->enableTracy(__DIR__ . '/log');
$configurator->setTempDirectory(__DIR__ . '/temp');
$configurator->addConfig(__DIR__ . '/config.neon');

$container = $configurator->createContainer();
$app = $container->getByType(Application::class);
$app->run();
