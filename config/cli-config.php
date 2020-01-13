<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

$config = require __DIR__ . '/../bootstrap/app.php';

return ConsoleRunner::createHelperSet($config);
