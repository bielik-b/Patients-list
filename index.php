<?php 
    require('auth/check-auth.php');
    require('data/declare-doctors.php');
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
            <?php  if(CheckRight('user','admin')): ?>
                <a href="admin\index.php">Адміністрування</a>
            <?php endif; ?>
            <a href="auth\logout.php">Вихід</a>
        </div>
        <?php if(CheckRight('doctor','view')): ?>
        <form name="doctor-form" method="get">
            <label for="doctor">Лікар</label>
            <select name="doctor" >
                <option value=""></option>
                <?php
                foreach($data['doctors'] as $curdoctor){
                    echo "<option " . (($GET['doctor']==$curdoctor['file'])?"selected":"") . " value=" . 
                    $curdoctor['file'] . ">" . $curdoctor['name'] . "</option>";
                }
                ?>
            </select>
            <input type="submit" value="Вибрати">
            <?php if(CheckRight('doctor','create')): ?>
            <a href="froms\create-list.php">Додати дані</a>
            <?php endif; ?>
        </form>
        <?php if($_GET['doctor']): ?>
            <?php
                $doctorsFolder = $_GET['doctor'];
                require('data\declare-data.php')
                ?>

        <h1>Лікар <span class='doctor-name'><?php echo $data['doctor']['name']; ?> </span></h1>
        <h2>Спеціалізація: <span class="doctor-specialization"><?php echo $data['doctor']['specialization']; ?></span></h2>
        <h3>Досвід: <span class="doctor-expirience"><?php echo $data['doctor']['expirience']; ?></span></h3>
        <div class="control">
            <?php if(CheckRight('doctor','edit')): ?>
                <a href="froms\edit-list.php?doctor=<?php echo $_GET['doctor']; ?>">Редагувати дані</a>
                <?php endif; ?>
                <?php if(CheckRight('doctor','delete')): ?>
                <a href="froms\delete-list.php?doctor=<?php echo $_GET['doctor']; ?>">Видалити дані</a>
                <?php endif; ?>
        </div>
        <?php endif; ?>
        <?php endif; ?>
    </header>
    <?php if(CheckRight('patient','view')): ?>
    <section>
        <?php if($_GET['doctor']): ?>
        <div class="control">
        <?php if(CheckRight('patient','create')): ?>
            <a  href="froms\create-patient.php?doctor=<?php echo $_GET['doctor']; ?>">Додати пацієнта</a>
            <?php endif; ?>
        </div>
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
                    <?php if(!$_POST['patient_name_filter'] || stristr($patient['name'], $_POST['patient_name_filter'])): ?>
                    <?php
                    $row_class = 'row';
                    if ($patient['gender'] == 'чол') {
                        $row_class = 'male';
                    }
                    if ($patient['gender'] == 'жін') {
                        $row_class = 'female';
                    }
                    ?>
                    <tr class='<?php echo $row_class; ?>'>
                        <td><?php echo ($key + 1); ?></td>
                        <td><?php echo $patient['name'] ?></td>
                        <td><?php echo $patient['gender'] ?></td>
                        <td><?php $date_of_birth = new Datetime($patient['date']);
                                    echo date_format($date_of_birth, 'Y');     
                                ?></td>
                        <td> 
                        <?php if(CheckRight('patient','edit')): ?>
                            <a href='froms\edit-patient.php?doctor=<?php echo $_GET['doctor']; ?>&file=<?php
                        echo $patient['file'];?>'>Редагувати
                             <?php endif; ?>
                        <?php if(CheckRight('patient','delete')): ?>   
                           <a href='froms\delete-patient.php?doctor=<?php echo $_GET['doctor']; ?>&file=<?php 
                            echo $patient['file'];?>'>Видалити</a>
                            <?php endif; ?>
                            </td>
                    </tr>
                    <?php endif; ?>
                <?php endforeach;  ?>
            </tbody>
        </table>
        <?php endif; ?>
    </section>
    <?php endif; ?>
</body>

</html>