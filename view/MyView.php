<?php

namespace view;

use Model\Doctor;
use Model\Patient;
use Model\User;

class MyView extends DoctorListView
{
    private function showDoctors($doctors)
    {
        ?>
        <form name='doctor-form' method='get'>
            <label for="doctor">Лікар</label>
            <select name="doctor">
                <option value=""></option>
                <?php
                foreach ($doctors as $curdoctor) {
                    echo "<option " . (($curdoctor->getId() == $_GET['doctor']) ? "selected" : "") . " value='" . $curdoctor->getId() . "''>" . $curdoctor->getName() . "</option>";
                }
                ?>
            </select>
            <input type="submit" value="ok">
            <?php if ($this->checkRight('doctor', 'create')) : ?>
                <a href="froms/create-doctor.php">Додати лікаря</a>
            <?php endif; ?>
        </form>
        <?php
    }
    private function showDoctor(Doctor $doctor)
    {
        ?>
        <h1>ПІБ <span class='doctor-name'><?php echo $doctor->getName(); ?></span></h1>
        <h2>Спеціаліація <span class="doctor-specialization"><?php echo $doctor->getSpecialization(); ?></span></h2>
        <h3>Стаж <span class="doctor-expirience"><?php echo $doctor->getExpirience(); ?></span></h3>
        <div class='control'>
            <?php if ($this->checkRight('doctor', 'edit')) : ?>
                <a href="froms/edit-doctor.php?doctor=<?php echo $_GET['doctor']; ?>">Редагувати лікаря</a>
            <?php endif; ?>
            <?php if ($this->checkRight('doctor', 'delete')) : ?>
                <a href="froms/delete-doctor.php?doctor=<?php echo $_GET['doctor']; ?>">Видалити лікаря</a>
            <?php endif; ?>
        </div>
        <?php
    }
    private function showPatients($patients)
    {
        ?>
        <section>
            <?php if ($_GET['doctor']) : ?>
                <?php if ($this->checkRight('patient', 'create')) : ?>
                    <div class='control'>
                        <a href="froms/create-patient.php?doctor=<?php echo $_GET['doctor']; ?>">Додати пацієнта</a>
                    </div>
                <?php endif; ?>
                <form name='patients-filter' method='post'>
                    Фільтрувати за назвою <input type="text" name="patient_name_filter" value='<?php echo $_POST['patient_name_filter']; ?>'>
                    <input type="submit" value="Фільтрувати">
                </form>
                <table>
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
                                    <td>
                                        <?php if ($this->checkRight('patient', 'edit')) : ?>
                                            <a href='froms/edit-patient.php?doctor=<?php echo $_GET['doctor']; ?>&file=<?php echo $patient->getId(); ?>'>Редагувати</a>
                                        <?php endif; ?>

                                        <?php if ($this->checkRight('patient', 'delete')) : ?>
                                            <a href='froms/delete-patient.php?doctor=<?php echo $_GET['doctor']; ?>&file=<?php echo $patient->getId(); ?>'>Видалити</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </section>
        <?php
    }
    public function showMainForm($doctors, Doctor $doctor, $patients)
    {
        ?>
        <!DOCUMENT html>
        <html>

        <head>
            <title>Список пацієнтів</title>
            <link rel="stylesheet"  href="css\edit-style-patient.css">
            <link rel="stylesheet"  href="css\gender-style.css">
            <link rel="stylesheet"  href="css\doctor-choose-style.css">
            <link rel="stylesheet"  href="css\style.css">
        </head>

        <body>
        <header>
            <div class="user-info">
                <span>Hello <?php echo $_SESSION['user']; ?>!</span>
                <?php if ($this->checkRight('user', 'admin')) : ?>
                    <a href="admin/index.php">Адміністрування</a>
                <?php endif; ?>
                <a href="auth/logout.php">Вихід</a>
            </div>
            <?php
            if ($this->checkRight('doctor', 'view')) {
                $this->showDoctors($doctors);
                if ($_GET['doctor']) {
                    $this->showDoctor($doctor);
                }
            }
            ?>
        </header>
        <?php
        if ($this->checkRight('doctor', 'view')) {
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
        <!DOCUMENT html>
        <html>

        <head>
            <title>Редагування інформації про лікаря</title>
            <link rel="stylesheet" type="text/css" href="../css/edit-style.css">
        </head>

        <body>
        <a href="../index.php?doctor=<?php echo $_GET['doctor']; ?>">На головну</a>
        <form name='edit-doctor' method='post'>
            <div><label for='name'>Ім'я лікаря : </label><input type="text" name="name" value="<?php echo $doctor->getName(); ?>"></div>
            <div><label for='specialization'>Спеціалізація : </label><input type="text" name="specialization" value="<?php echo $doctor->getSpecialization(); ?>"></div>
            <div><label for='expirience'>Стаж : </label><input type="text" name="expirience" value="<?php echo $doctor->getExpirience(); ?>"></div>
            <div><input type="submit" name="ok" value="змінити"></div>
        </form>
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
            <link rel="stylesheet" type="text/css" href="..\css\edit-style-patient.css">
        </head>

        <body>
        <a href="../index.php?doctor=<?php echo $_GET['doctor']; ?>">На головну</a>
        <form name='edit-patient' method='post'>
            <div>
                <label for='patient_name'>Назва пацієнта : </label>
                <input type="text" name="patient_name" value='<?php echo $patient->getName(); ?>'>
            </div>
            <div>
                <label for='patient_genre'>Стать : </label>
                <select name="patient_genre">
                    <option disabled>Жанр</option>
                    <option <?php echo ($patient->isGenderMale()) ? "selected" : ""; ?> value="male">чоловіча</option>
                    <option <?php echo ($patient->isGenderFemale()) ? "selected" : ""; ?> value="female">жіноча</option>
                </select>
            </div>
            <div>
                <label for='patient_publ'>Дата народження : </label>
                <input type="text" name="patient_date" value='<?php echo $patient->getDate(); ?>'>
            </div>
            <div>
            <div>
                <input type="checkbox" <?php echo ($patient->isPrivilege()) ? "checked" : ""; ?> name="patient_privilege" value=1> Знижка
            </div>
            <div><input type="submit" name="ok" value="змінити"></div>
        </form>
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
            <link rel="stylesheet" href="..\css\edit-style-patient.css">
        </head>
        <body>
        <a href="../index.php">На Головну</a>
        <form name='edit-patient' method='post'>
            <div>
                <label for='patinent_name'> ПІБ: </label>
                <input type="text" name="patient_name">
            </div>
            <div>
                <label for='patient_gender'>Стать: </label>
                <select name="patient_gender">
                    <option disabled>Стать</option>
                    <option value="чол">Чоловіча</option>
                    <option value="жін">Жіноча</option>
                </select>
            </div>
            <div>
                <label for="patient_date">Дата Народження</label>
                <input type="date" name="patient_date">
            </div>
            <div>
                <input type="checkbox" name="patient_privilege" value=1> пільга
            </div>
            <div>
                <input type="submit" name="okay" value="Додати" >
            </div>
        </form>
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
            <link rel="stylesheet" type="text/css" href="../css/login-style.css">
        </head>

        <body>
        <form method="post">
            <p>
                <input align="center" type="text" name="username" placeholder="username">
            </p>
            <p>
                <input type="password" name="password" placeholder="password">
            </p>
            <p>
                <input type="submit" value="login">
            </p>
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
            <a href="../index.php">На головну</a>
            <h1>Адміністрування користувачів</h1>>
            <link rel="stylesheet" type="text/css" href="../css/main-style.css">
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
                            <td><a href="admin/edit-user.php?username=<?php echo $user->getUserName(); ?>"><?php echo $user->getUserName(); ?></a></td>
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
            <link rel="stylesheet" type="text/css" href="admin/admin.css">
        </head>

        <body>
        <a href="index.php">До списку користувачів</a>
        <form name='edit-user' method='post'>
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
                <p>Лікар:</p>
                <input type="checkbox" <?php echo ("1" == $user->getRight(0)) ? "checked" : ""; ?> name="right0" value="1"><span>перегляд</span>
                <input type="checkbox" <?php echo ("1" == $user->getRight(1)) ? "checked" : ""; ?> name="right1" value="1"><span>створення</span>
                <input type="checkbox" <?php echo ("1" == $user->getRight(2)) ? "checked" : ""; ?> name="right2" value="1"><span>редагування</span>
                <input type="checkbox" <?php echo ("1" == $user->getRight(3)) ? "checked" : ""; ?> name="right3" value="1"><span>видалення</span>
            </div>
            <div>
                <p>Книги:</p>
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
