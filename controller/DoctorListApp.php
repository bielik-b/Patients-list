<?php

namespace Controller;

use DateTime;
use Model\Data;
use Model\Doctor;
use Model\Patient;
use Model\User;
use View\DoctorListView;

class DoctorListApp
{
    private $model;
    private $view;

    public function __construct($modelType, $viewType)
    {
        session_start();
        $this->model = Data::makeModel($modelType);
        $this->view = DoctorListView::makeView($viewType);
    }

    public function checkAuth()
    {
        if ($_SESSION['user']) {
            $this->model->setCurrentUser($_SESSION['user']);
            $this->view->setCurrentUser($this->model->getCurrentUser());
        } else {
            header('Location: ?action=login');
        }
    }

    public function run()
    {
        if (!in_array($_GET['action'], array('login', 'checkLogin'))) {
            $this->checkAuth();
        }
        if ($_GET['action']) {
            switch ($_GET['action']) {
                case 'login':
                    $this->showLoginForm();
                    break;
                case 'checkLogin':
                    $this->checkLogin();
                    break;
                case 'logout':
                    $this->logout();
                    break;
                case 'create-doctor':
                    $this->createDoctor();
                    break;
                case 'edit-doctor-form':
                    $this->showEditDoctorForm();
                    break;
                case 'edit-doctor':
                    $this->editDoctor();
                    break;
                case 'delete-doctor':
                    $this->deleteDoctor();
                    break;
                case 'create-patient-form':
                    $this->showCreatePatientForm();
                    break;
                case 'create-patient':
                    $this->createPatient();
                    break;
                case 'edit-patient-form':
                    $this->showEditPatientForm();
                    break;
                case 'edit-patient':
                    $this->editPatient();
                    break;
                case 'delete-patient':
                    $this->deletePatient();
                    break;
                case 'admin':
                    $this->adminUsers();
                    break;
                case 'edit-user-form':
                    $this->showEditUserForm();
                    break;
                case 'edit-user':
                    $this->editUser();
                    break;
                default:
                    $this->showMainForm();
            }
        } else {
            $this->showMainForm();
        }
    }
    private function showLoginForm()
    {
        $this->view->showLoginForm();
    }
    private function checkLogin()
    {
        if ($user = $this->model->readUser($_POST['username'])) {
            if ($user->checkPassWord($_POST['password'])) {
                session_start();
                $_SESSION['user'] = $user->getUserName();
                header('Location: index.php');
            }
        }
    }
    private function logout()
    {
        unset($_SESSION['user']);
        header('Location: ?action=login');
    }
    private function showMainForm()
    {
        $doctors = array();
        if ($this->model->checkRight('doctor', 'view')) {
            $doctors = $this->model->readDoctors();
        }
        $doctor = new Doctor();
        if ($_GET['doctor'] && $this->model->checkRight('doctor', 'view')) {
            $doctor = $this->model->readDoctor($_GET['doctor']);
        }
        $patients = array();
        if ($_GET['doctor'] && $this->model->checkRight('patient', 'view')) {
            $patients = $this->model->readPatients($_GET['doctor']);
        }
        $this->view->showMainForm($doctors, $doctor, $patients);
    }
    private function createDoctor()
    {
        if (!$this->model->addDoctor()) {
            die($this->model->getError());
        } else {
            header('Location: index.php');
        }
    }
    private function showEditDoctorForm()
    {
        if (!$doctor = $this->model->readDoctor($_GET['doctor'])) {
            die($this->model->getError());
        }
        $this->view->showDoctorEditForm($doctor);
    }
    private function editDoctor()
    {
        if (!$this->model->writeDoctor((new Doctor())
            ->setId($_GET['doctor'])
            ->setName($_POST['name'])
            ->setSpecialization($_POST['specialization'])
            ->setExpirience($_POST['expirience'])
        )) {
            die($this->model->getError());
        } else {
            header('Location: index.php?doctor=' . $_GET['doctor']);
        }
    }
    private function deleteDoctor()
    {
        if (!$this->model->removeDoctor($_GET['doctor'])) {
            die($this->model->getError());
        } else {
            header('Location: index.php');
        }
    }
    private function showEditPatientForm()
    {
        $patient = $this->model->readPatient($_GET['doctor'], $_GET['file']);
        $this->view->showPatientEditForm($patient);
    }
    private function editPatient()
    {
        $patient = (new Patient())
            ->setDoctorId($_GET['doctor'])
            ->setName($_POST['name'])
            ->setDate(new DateTime($_POST['date']))
            ->setPrivilege($_POST['privilege'])
            ->setFemaleGender();
        if($_POST['gender']=='чол'){
            $patient->setMaleGender();
        }
        if(!$this->writePatient($patient)){
            die($this->getError());
        }else {
            header('Location: ../index.php?doctor=' . $_GET['doctor']);
        }
    }
    private function showCreatePatientForm()
    {
        $this->view->showPatientCreateForm();
    }
    private function createPatient()
    {
        $patient = (new Patient())
            ->setDoctorId($_GET['doctor'])
            ->setName($_POST['name'])
            ->setDate(new DateTime($_POST['date']))
            ->setPrivilege($_POST['privilege'])
            ->setFemaleGender();
        if($_POST['gender']=='чол'){
            $patient->setMaleGender();
        }
        if(!$this->writePatient($patient)){
            die($this->getError());
        }else {
            header('Location: ../index.php?doctor=' . $_GET['doctor']);
        }
    }
    private function deletePatient()
    {
        $patient = (new Patient())->setId($_GET['file'])->setDoctorId($_GET['doctor']);
        if (!$this->model->removePatient($patient)) {
            die($this->model->getError());
        } else {
            header('Location: index.php?doctor=' . $_GET['doctor']);
        }
    }
    private function adminUsers()
    {
        $users = $this->model->readUsers();
        $this->view->showAdminForm($users);
    }
    private function showEditUserForm()
    {
        if (!$user = $this->model->readUser($_GET['username'])) {
            die($this->model->getError());
        }
        $this->view->showUserEditForm($user);
    }
    private function editUser()
    {
        $rights = "";
        for ($i = 0; $i < 9; $i++) {
            if ($_POST['right' . $i]) {
                $rights .= "1";
            } else {
                $rights .= "0";
            }
        }
        $user = (new User())
            ->setUserName($_POST['user_name'])
            ->setPassword($_POST['user_pwd'])
            ->setRights($rights);
        if (!$this->model->writeUser($user)) {
            die($this->model->getError());
        } else {
            header('Location: ?action=admin ');
        }
    }
}
