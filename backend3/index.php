<?php
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (!empty($_GET['save'])) {
    print('Спасибо, результаты сохранены.');
    if($_GET['id']){
    print('Ваш ID:'.$_GET['id']);
    }
  }
  include('form.php');
  exit();
}


$errors = FALSE;
if (empty($_POST['fio'])) {
  print('Заполните имя.<br/>');
  $errors = TRUE;
}
if (empty($_POST['email'])) {
  print('Заполните Email.<br/>');
  $errors = TRUE;
}
if (empty($_POST['date'])) {
  print('Заполните дату рождения.<br/>');
  $errors = TRUE;
}
if (empty($_POST['gender'])) {
  print('Выберите пол.<br/>');
  $errors = TRUE;
}
if (empty($_POST['arms'])) {
  print('Выберите количество конечностей.<br/>');
  $errors = TRUE;
}
if (empty($_POST['arg'])) {
  print('Выберите сверхспособность.<br/>');
  $errors = TRUE;
}
if (empty($_POST['about'])) {
  print('Напишите биографию.<br/>');
  $errors = TRUE;
}
if(empty($_POST['check'])){
  print('Вы не прочитали контракт.<br/>');
  $errors = TRUE;
}

if ($errors) {
  exit();
}


$user = 'u47522';
$pass = '7677055';
$db = new PDO('mysql:host=localhost;dbname=u47522', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
if($db){
  print('fine');
}else{
  print('no');
  exit();
}
$fio = $_POST['fio'];
$email = $_POST['email'];
$date = $_POST['date'];
$gender = $_POST['gender'];
$arms = $_POST['arms'];
$about = $_POST['about'];

$arg = implode(',',$_POST['arg']);
try {

  $stmt = $db->prepare("INSERT INTO heroes SET fio = ?, email = ?, date = ?, gender = ?, arms = ?, about = ?");
  $stmt -> execute([$fio,$email,$date,$gender,$arms,$about]);
  $id = $db->lastInsertId();

  $new = $db->prepare("INSERT INTO abilities SET id = ?, ability = ?");
  $new -> execute([$id, $arg]); 
}
catch(PDOException $e){
  print('Error : ' . $e->getMessage());
  exit();
}
header('Location: ?save=1&id='.$id);
