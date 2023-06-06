<?php

use Controller\AuthorListApp;
use controller\DoctorListApp;
use View\AuthorListView;

require 'data/config.php';
require 'controller/autorun.php';
$controller = new DoctorListApp(Config::$modelType, Config::$viewType);
$controller->run();