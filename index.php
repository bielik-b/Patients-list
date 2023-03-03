<?php 
    require('auth/check-auth.php');
    require_once 'model/autorun.php';
    $myModel = Model\Data::makeModel(Model\Data::FILE);
    $myModel->setCurrentUser($_SESSION['user']);
?>
<!DOCTYPE html>
<html>

<head>
    <title> Doctor</title>

    <link rel="stylesheet" href="css\style.css">
    <link rel="stylesheet" href="css\gender-style.css">
    <link rel="stylesheet" href="css\doctor-choose-style.css">

</head>

<body>
    <header>
        <div class="user-info">
            <span>Hello <?php echo $_SESSION['user'];?> ! </span>
            <?php  if($myModel->checkRight('user', 'admin')): ?>
                <a href="admin\index.php">Адміністрування</a>
            <?php endif; ?>
            <a href="auth\logout.php">Вихід</a>
        </div>
        <?php if($myModel->checkRight('doctor','view')): ?>
            <?php $data['doctors'] = $myModel->readDoctors() ?>
        <form name="doctor-form" method="get">
            <label for="doctor">Лікар</label>
            <select name="doctor" >
                <option value=""></option>
                <?php
                foreach($data['doctors'] as $curdoctor){
                    echo "<option "  . (($curdoctor->getId() == $_GET['doctor'])?"selected":"") . " value='"
                     . $curdoctor->getId() . "''>" . $curdoctor->getName() . "</option>";
                }
                ?>
            </select>
            <input type="submit" value="Вибрати">
            <?php if($myModel->checkRight('doctor','create')): ?>
            <a href="froms\create-doctor.php">Додати дані</a>
            <?php endif; ?>
        </form>
        <?php if($_GET['doctor']): ?>
            <?php
                $data['doctor'] = $myModel->readDoctor($_GET['doctor']);
                ?>

        <h1>Лікар <span class='doctor-name'><?php echo $data['doctor']->getName(); ?> </span></h1>
        <h2>Спеціалізація: <span class="doctor-specialization"><?php echo $data['doctor']->getSpecialization(); ?></span></h2>
        <h3>Досвід: <span class="doctor-expirience"><?php echo $data['doctor']->getExpirience(); ?></span></h3>
        <div class="control">
            <?php if($myModel->checkRight('doctor','edit')): ?>
                <a href="froms\edit-doctor.php?doctor=<?php echo $_GET['doctor']; ?>">Редагувати дані</a>
                <?php endif; ?>
                <?php if($myModel->checkRight('doctor','delete')): ?>
                <a href="froms\delete-doctor.php?doctor=<?php echo $_GET['doctor']; ?>">Видалити дані</a>
                <?php endif; ?>
        </div>
        <?php endif; ?>
        <?php endif; ?>
    </header>
    <?php if($myModel->checkRight('patient', 'view')): ?>
        <?php $data['patients'] = $myModel->readPatients($_GET['doctor']); ?>
    <section>
        <?php if($_GET['doctor']): ?>
        <div class="control">
        <?php if($myModel->checkRight('patient', 'create')): ?>
            <a  href="froms\create-patient.php?doctor=<?php echo $_GET['doctor']; ?>">Додати пацієнта</a>
            <?php endif; ?>
        </div>
        <?php if ($data['patients']) : ?>
       <form name='patients-filter' method='post'>
            Фільтрування за прізвищем <input type="text" name="patient_name_filter" value=
            '<?php echo $_POST['patient_name_filter']; ?>'>
            <input type="submit" value="Фільтрувати">
       </form>
        <table border="1">
            <thead>
                <tr>
                    <th>№ п.п.</th>
                    <th>ПІБ</th>
                    <th>Стать</th>
                    <th>Дата Народження</th>
                    <th></th>
                    

                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['patients'] as $key => $patient) : ?>
                    <?php if(!$_POST['patient_name_filter'] || stristr($patient->getName(), $_POST['patient_name_filter'])): ?>
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
                        <?php if($myModel->checkRight('patient', 'edit')): ?>
                            <a href='froms\edit-patient.php?doctor=<?php echo $_GET['doctor']; ?>&file=<?php
                        echo $patient->getId();?>'>Редагувати
                             <?php endif; ?>
                        <?php if($myModel->checkRight('patient', 'edit')): ?>
                           <a href='froms\delete-patient.php?doctor=<?php echo $_GET['doctor']; ?>&file=<?php 
                            echo $patient->getId();?>'>Видалити</a>
                            <?php endif; ?>
                            </td>
                    </tr>
                    <?php endif; ?>
                <?php endforeach;  ?>
                <?php endif; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </section>
    <?php endif; ?>
</body>

</html>