<?php declare(strict_types = 1);

namespace NextrasDemos\FormsRendering\LatteMacros;

use Nette\Application\Application;
use Nette\Configurator;

require_once __DIR__ . '/../../vendor/autoload.php';


$configurator = new Configurator;
$configurator->enableDebugger(__DIR__ . '/log');
$configurator->setTempDirectory(__DIR__ . '/temp');
$configurator->createRobotLoader()->addDirectory(__DIR__)->register();
$configurator->addConfig(__DIR__ . '/config.neon');

$container = $configurator->createContainer();
$app = $container->getByType(Application::class);
$app->run();
