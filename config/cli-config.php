<?php
declare(strict_types=1);

use Doctrine\ORM\Tools\Console\ConsoleRunner;

require __DIR__ . '/../bootstrap/app.php';

use App\Application;
use Doctrine\ORM\EntityManagerInterface;

Application::createDI();

return ConsoleRunner::createHelperSet(Application::getDI()->get(EntityManagerInterface::class));
