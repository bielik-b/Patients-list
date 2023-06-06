<?php

namespace view;

use Model\Doctor;
use Model\Patient;
use Model\User;

class BootstrapView extends DoctorListView
{
    const ASSETS_FOLDER = 'view/bootstrap-view/';
    private function showUserInfo()
    {
        ?>
        <div class="container user-info">
            <div class="row">
                <div class="col-12 col-sm-10 offset-sm-2 col-md-8 offset-md-4 text-center lead">
                    <span><b>Hello <?php echo $_SESSION['user']; ?> !</b></span>
                    <?php if ($this->checkRight('user', 'admin')) : ?>
                        <a class="btn btn-primary" href="?action=admin">Адміністрування</a>
                    <?php endif; ?>
                    <a class="btn btn-info" href="?action=logout">Вихід</a>
                </div>
            </div>
        </div>
        <?php
    }
    private function showDoctors($doctors)
    {
        ?>
        <div class="container doctor-list">
            <div class="row">
                <form name="doctor-form" method="get" class="offset-2 col-8 offset-sm-3 col-sm-6">
                    <div class="form-doctor">
                        <label for="doctor">Ліка :</label>
                        <select name="doctor" class="form-control" onchange="document.forms['doctor-form'].submit();">
                            <option value=""></option>
                            <?php
                            foreach ($doctors as $curdoctor) {
                                echo "<option " . (($curdoctor->getId() == $_GET['doctor']) ? "selected" : "") . " value='" . $curdoctor->getId() . "''>" . $curdoctor->getName() . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </form>
                <?php if ($this->checkRight('doctor', 'create')) : ?>
                    <div class="col-12 text-center">
                        <a class='btn btn-success' href="?action=create-doctor">Додати лікаря</a>
                    </div>

                <?php endif; ?>
            </div>
        </div>
        <?php
    }
    private function showDoctor(Doctor $doctor)
    {
        ?>
        <div class="container doctor-info">
            <div class="row text-center">
                <h1 class="col-12">ПІБ :<span class='text-primary'><?php echo $doctor->getName(); ?></span></h1>
                <h3 class="col-12 col-md-5 offset-md-1">Спеціалізація :<span class='text-danger'><?php echo $doctor->getSpecialization(); ?></span></h3>
                <h3 class="col-12 col-md-5">Стаж <span class='text-success'><?php echo $doctor->getExpirience(); ?></span></h3>
                <div class='doctor-control col-12'>
                    <?php if ($this->checkRight('doctor', 'edit')) : ?>
                        <a class="btn btn-primary" href="?action=edit-doctor-form&doctor=<?php echo $_GET['doctor']; ?>">Редагувати лікаря</a>
                    <?php endif; ?>
                    <?php if ($this->checkRight('doctor', 'delete')) : ?>
                        <a class="btn btn-danger" href="?action=delete-doctor&doctor=<?php echo $_GET['doctor']; ?>">Видалити лікаря</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }
    private function showPatients($patients)
    {
        ?>
        <section class="container patients">
            <div class="row text-center">
                <?php if ($_GET['doctor']) : ?>
                <?php if ($this->checkRight('patient', 'create')) : ?>
                    <div class="col-12 col-md-3 text-rigth add-patient">
                        <a class="btn btn-success" href="?action=create-patient-form&doctor=<?php echo $_GET['doctor']; ?>">Додати пацієнта</a>
                    </div>
                <?php endif; ?>
                <div class="col-12 col-md-8">
                    <form name='patients-filter' method='post'>
                        <div class="row">
                            <div class="col-5">
                                <label for="patient_name_filter"><b>Фільтрувати за ім'ям</b></label>
                            </div>
                            <div class="col-4">
                                <input class="form-control" type="text" name="patient_name_filter" value='<?php echo $_POST['patient_name_filter']; ?>'>
                            </div>
                            <div class="col-3">
                                <input type="submit" value="фільтрувати" class='btn btn-info'>
                            </div>
                    </form>
                </div>
            </div>
            <div class="row text-center table-patients col-12">
                <table class="table table-sm col-12">
                    <thead>
                    <tr>
                        <th>№</th>
                        <th>ПІБ </th>
                        <th>Стать </th>
                        <th>Дата народження </th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (count($patients) > 0) : ?>
                        <?php foreach ($patients as $key => $patient) : ?>
                            <?php if (!$_POST['patient_name_filter'] || stristr($patient->getName(), $_POST['patient_name_filter'])) : ?>
                                <?php
                                $row_class = 'row';
                                if ($patient->isGenderMale()) {
                                    $row_class = 'male';
                                }
                                if ($patient->isGenderFemale()) {
                                    $row_class = 'female';
                                }
                                ?>
                                <tr class='<?php echo $row_class; ?>'>
                                    <td><?php echo ($key + 1); ?></td>
                                    <td><?php echo $patient->getName() ?></td>
                                    <td><?php echo $patient->isGenderMale()?'чол':'жін'; ?></td>
                                    <td><?php echo date_format($patient->getDate(), 'Y');
                                        ?></td>
                                    </td>
                                    <td>
                                        <?php if ($this->checkRight('patient', 'edit')) : ?>
                                            <a class="btn btn-primary btn-sm" href='?action=edit-patient-form&doctor=<?php echo $_GET['doctor']; ?>&file=<?php echo $patient->getId(); ?>'>Редагувати</a>
                                        <?php endif; ?>
                                        <?php if ($this->checkRight('patient', 'delete')) : ?>
                                            <a class="btn btn-danger btn-sm" href='?action=delete-patient&doctor=<?php echo $_GET['doctor']; ?>&file=<?php echo $patient->getId(); ?>'>Видалити</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
    public function showMainForm($doctors, Doctor $doctor, $patients)
    {
        ?>
        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="UTF-8">
            <link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/bootstrap.min.css">
            <link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/main.css">
            <title>Document</title>
        </head>

        <body>
        <header>
            <?php
            $this->showUserInfo();
            if ($this->checkRight('doctor', 'view')) {
                $this->showDoctors($doctors);
                if ($_GET['doctor']) {
                    $this->showDoctor($doctor);
                }
            } ?>
        </header>
        <?php
        if ($this->checkRight('patient', 'view')) {
            $this->showPatients($patients);
        }
        ?>
        </body>

        </html>
        <?php
    }
    public function showDoctorEditForm(Doctor $doctor)
    {
        ?>
        <!DOCTYPE html>
        <html>

        <head>
            <title>Редагування лікаря</title>
            <link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/bootstrap.min.css">
        </head>

        <body>
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                    <form name='edit-doctor' method='post' action="?action=edit-doctor&doctor=<?php echo $_GET['doctor']; ?>">
                        <div class="form-doctor"><label for='name'>ПІБ : </label><input class="form-control" type="text" name="name" value="<?php echo $doctor->getName(); ?>"></div>
                        <div class="form-doctor"><label for='country'>Спеціалізація </label><input class="form-control" type="text" name="country" value="<?php echo $doctor->getSpecialization(); ?>"></div>
                        <div class="form-doctor"><label for='dateofbirth'>Стаж </label><input class="form-control" type="text" name="dateofbirth" value="<?php echo $doctor->getExpirience(); ?>"></div>
                        <button type="submit" class="btn btn-success float-right">змінити</button>
                        <a class=" btn btn-info btn-sm float-left" href="index.php?doctor=<?php echo $_GET['doctor']; ?>">На головну</a>
                    </form>
                </div>
            </div>
        </div>
        </body>

        </html>
        <?php
    }
    public function showPatientEditForm(Patient $patient)
    {
        ?>
        <!DOCTYPE html>
        <html>

        <head>
            <title>Редагування пацієнта</title>
            <link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/bootstrap.min.css">
            <link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/checkbox.css">
        </head>

        <body>
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-8 col-md-6 col-lg-4">

                    <form name='edit-patient' method='post' action="?action=edit-patient&file=<?php echo $_GET['file']; ?>&doctor=<?php echo $_GET['doctor']; ?>">
                        <div class="form-doctor">
                            <label for='patient_name'>ПІБ </label>
                            <input class="form-control" type="text" name="patient_name" value='<?php echo $patient->getName(); ?>'>
                        </div>
                        <div class="form-doctor">
                            <label for='patient_genre'>Стать  </label>
                            <select class="form-control" name="patient_gender">
                                <option disabled>Жанр</option>
                                <option <?php echo ($patient->isGenderMale()) ? "selected" : ""; ?> value="чол">Чоловіча</option>
                                <option <?php echo ($patient->isGenderFemale()) ? "selected" : ""; ?> value="жін">Жіноча</option>
                            </select>
                        </div>
                        <div class="form-doctor">
                            <label for='patient_dop'>Дата народження : </label>
                            <input class="form-control" type="date" name="patient_date" value='<?php echo $patient->getDate()->format('Y'); ?>'>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" <?php echo ($patient->isPrivilege()) ? "checked" : ""; ?> name="patient_privilege" value=1>
                                Знижка
                            </label>
                        </div>

                        <button type="submit" class="btn btn-success float-right">змінити</button>
                        <a class="btn btn-info float-left btn-sm" href="index.php?doctor=<?php echo $_GET['doctor']; ?>">На головну</a>
                    </form>
                </div>
            </div>
        </div>
        </body>

        </html>
        <?php
    }
    public function showPatientCreateForm()
    {
        ?>
        <!DOCTYPE html>
        <html>

        <head>
            <title>Додавання пацієнта</title>
            <link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/bootstrap.min.css">
            <link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/checkbox.css">
        </head>

        <body>
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-8 col-md-6 col-lg-4">

                    <form name='edit-patient' method='post' action="?action=create-patient&doctor=<?php echo $_GET['doctor']; ?>">
                        <div class="form-doctor">
                            <label for='patient_name'>ПІБ </label>
                            <input class="form-control" type="text" name="patient_name">
                        </div>
                        <div class="form-doctor">
                            <label for='patient_genre'>Стать </label>
                            <select class="form-control" name="patient_gender">
                                <option disabled>Стать</option>
                                <option value="чол">Чоловіча</option>
                                <option value="жін">Жіноча</option>
                            </select>
                        </div>
                        <div class="form-doctor">
                            <label for='patient_dop'>Дата Народження </label>
                            <input class="form-control" type="date" name="patient_date">
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="patient_privilege" value=1> Знижка
                            </label>
                        </div>
                        <button type="submit" class="btn btn-success float-right">додати</button>
                        <a class="btn btn-info float-left  btn-sm" href="index.php?doctor=<?php echo $_GET['doctor']; ?>">На головну</a>
                    </form>
                </div>
            </div>
        </div>
        </body>

        </html>
        <?php
    }
    public function showLoginForm()
    {
        ?>
        <!DOCTYPE html>
        <html>

        <head>
            <title>Аутентифiкацiя</title>
            <link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/bootstrap.min.css">
            <link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/login.css">
        </head>

        <body>
        <form method="post" action="?action=checkLogin">
            <div class="container">
                <div class="row text-center">
                    <div class="col-sm-6 col-md-4 col-lg-3 offset-sm-3 offset-md-4">
                        <div class="form-doctor">
                            <input name="username" placeholder="username" class="form-control">
                        </div>
                        <div class="form-doctor">
                            <input type="password" name="password" placeholder="password" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">login</button>
                    </div>
                </div>
            </div>
        </form>
        </body>

        </html>
        <?php
    }
    public function showAdminForm($users)
    {
        ?>
        <!DOCTYPE html>
        <html>

        <head>
            <title>Адміністрування</title>
        </head>

        <body>
        <header>
            <a href="index.php">На головну</a>
            <h1>Адміністрування користувачів</h1>>
            <link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/bootstrap.min.css">
            <link rel="stylesheet" type="text/css" href="css/main-style.css">
        </header>
        <section>
            <table>
                <thead>
                <tr>
                    <th>Користувач</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user) : ?>
                    <?php if ($user->getUserName() != $_SESSION['user'] && $user->getUserName() != 'admin' && trim($user->getUserName()) != '') : ?>
                        <tr>
                            <td><a href="?action=edit-user-form&username=<?php echo $user->getUserName(); ?>"><?php echo $user->getUserName(); ?></a></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        </body>

        </html>
        <?php
    }
    public function showUserEditForm(User $user)
    {
        ?>
        <!DOCTYPE html>
        <html>

        <head>
            <title>Редагування користувача</title>
            <link rel="stylesheet" type="text/css" href="admin.css">
        </head>

        <body>
        <a href="?action=admin">До списку користувачів</a>
        <form name='edit-user' method='post' action="?action=edit-user&user=<?php echo $_GET['user']; ?>">
            <div class='tbl'>
            </div>
            <label for='user_name'>Username: </label>
            <input readonly type="text" name="user_name" value='<?php echo $user->getUserName(); ?>'>
            </div>
            <div>
                <label for='user_pwd'>Password: </label>
                <input type="text" name="user_pwd" value='<?php echo $user->getPassword(); ?>'>
            </div>
            </div>
            <div>
                <p>Ліка:</p>
                <input type="checkbox" <?php echo ("1" == $user->getRight(0)) ? "checked" : ""; ?> name="right0" value="1"><span>перегляд</span>
                <input type="checkbox" <?php echo ("1" == $user->getRight(1)) ? "checked" : ""; ?> name="right1" value="1"><span>створення</span>
                <input type="checkbox" <?php echo ("1" == $user->getRight(2)) ? "checked" : ""; ?> name="right2" value="1"><span>редагування</span>
                <input type="checkbox" <?php echo ("1" == $user->getRight(3)) ? "checked" : ""; ?> name="right3" value="1"><span>видалення</span>
            </div>
            <div>
                <p>Книга:</p>
                <input type="checkbox" <?php echo ("1" == $user->getRight(4)) ? "checked" : ""; ?> name="right4" value="1"><span>перегляд</span>
                <input type="checkbox" <?php echo ("1" == $user->getRight(5)) ? "checked" : ""; ?> name="right5" value="1"><span>створення</span>
                <input type="checkbox" <?php echo ("1" == $user->getRight(6)) ? "checked" : ""; ?> name="right6" value="1"><span>редагування</span>
                <input type="checkbox" <?php echo ("1" == $user->getRight(7)) ? "checked" : ""; ?> name="right7" value="1"><span>видалення</span>
            </div>
            <div>
                <p>Користувачі:</p>
                <input type="checkbox" <?php echo ("1" == $user->getRight(8)) ? "checked" : ""; ?> name="right8" value="1"><span>адміністування</span>
            </div>
            <div><input type="submit" name="ok" value="змінити"></div>
        </form>
        </body>

        </html>
        <?php
    }
}
