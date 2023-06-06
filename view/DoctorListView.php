<?php

namespace view;

use Model\Doctor;
use Model\Patient;
use Model\User;

abstract class DoctorListView {
    const SIMPLEVIEW = 0;
    const BOOTSTRAPVIEW = 1;
    private $user;

    public function setCurrentUser(User $user) {
        $this->user = $user;
    }
    public function checkRight($object, $right) {
        return $this->user->checkRight($object, $right);
    }

    public abstract function showMainForm($doctors, Doctor $doctor, $patients);
    public abstract function showDoctorEditForm(Doctor $doctor);
    public abstract function showPatientEditForm(Patient $patient);
    public abstract function showPatientCreateForm();
    public abstract function showLoginForm();
    public abstract function showAdminForm($users);
    public abstract function showUserEditForm(User $user);

    public static function makeView($type) {
        if ($type == self::SIMPLEVIEW) {
            return new MyView();
        } elseif ($type == self::BOOTSTRAPVIEW){
            return new BootstrapView();
        }
        return new MyView();
    }
}