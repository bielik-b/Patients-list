<?php
require('auth/check-auth.php');

require_once 'model/autorun.php';
$myModel = Model\Data::makeModel(Model\Data::FILE);
$myModel->setCurrentUser($_SESSION['user']);

require_once 'view/autorun.php';
$myView = \View\DoctorListView::makeView(\View\DoctorListView::SIMPLEVIEW);
$myView->setCurrentUser($myModel->getCurrentUser());

$doctors = array();
if ($myModel->checkRight('doctor', 'view')) {
    $doctors = $myModel->readDoctors();
}
$doctor = new \Model\Doctor();
if ($_GET['doctor'] && $myModel->checkRight('doctor', 'view')) {
    $doctor = $myModel->readDoctor($_GET['doctor']);
}
$patients = array();
if ($_GET['doctor'] && $myModel->checkRight('patient', 'view')) {
    $patients = $myModel->readPatients(($_GET['doctor']));
}

$myView->showMainForm($doctors, $doctor, $patients);
