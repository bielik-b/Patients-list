<?php

use Controller\AuthorListApp;
use Controller\DoctorListApp;
use Model\Data;
use View\AuthorListView;
use view\DoctorListView;

require 'controller/autorun.php';
$controller = new DoctorListApp(Data::FILE, DoctorListView::SIMPLEVIEW);
$controller->run();