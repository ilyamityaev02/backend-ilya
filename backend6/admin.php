<?php
$user = 'u47522';
$pass = '7677055';
$db = new PDO('mysql:host=localhost;dbname=u47522', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
$stmt = $db->prepare("SELECT * FROM admins");
$stmt -> execute([]);
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
$adm = $row[0]['login'];
$pass = $row[0]['password'];
// login = admin
// pass = 123;
if (empty($_SERVER['PHP_AUTH_USER']) ||
    empty($_SERVER['PHP_AUTH_PW']) ||
    $_SERVER['PHP_AUTH_USER'] != $adm ||
    md5($_SERVER['PHP_AUTH_PW']) != $pass) {
  header('HTTP/1.1 401 Unanthorized');
  header('WWW-Authenticate: Basic realm="My site"');
  print('<h1>401 Требуется авторизация</h1>');
  exit();
}

print('Вы успешно авторизовались и видите защищенные паролем данные.');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	$user = 'u47522';
  $pass = '7677055';
  $db = new PDO('mysql:host=localhost;dbname=u47522', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
    try {
  
      $stmt = $db->prepare("SELECT * FROM heroes2");
      $stmt -> execute([]); 
	  $stmt2 = $db->prepare("SELECT ability FROM abilities2 WHERE login = ?");
	  $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		print('<p>Список пользователей:</p>');
	  foreach($row as $user){
		  		  $values = $user;
		  $abilities = '';
		  $stmt2 -> execute([$user['login']]);
		  $row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
		  foreach($row2 as $symb){
			$abilities.=($symb['ability'].',');
		  }
		$values['arg'] = $abilities;
		  $abilities = substr($abilities, 0,-1);
		print('<div>
		');
		include('adm_form.php');
		print('</div>');

	  }
	  print('Количество пользователей с каждой сверхспособностью:');
	    $stmtCount = $db->prepare('SELECT ability, COUNT(ability) as amount FROM abilities2 GROUP BY ability');
        $stmtCount->execute();
        print('<section>');
        while($row = $stmtCount->fetch(PDO::FETCH_ASSOC)) {
            print('<b>' . $row['ability'] . '</b>: ' . $row['amount'] . '<br/>');
        }
        print('</section><br>');
    }
    catch(PDOException $e){
      print('Error : ' . $e->getMessage());
      exit();
    }
}else{
	if(array_key_exists('delete', $_POST)){
		$user = 'u47522';
		$pass = '7677055';
		$db = new PDO('mysql:host=localhost;dbname=u47522', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
		try {
			$stmt = $db->prepare("SELECT login FROM heroes2 WHERE id = ?");
			$stmt -> execute([$_POST['uid']]);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$l = $row['login'];
			$stmt2 = $db->prepare("DELETE FROM heroes2 WHERE login = ?");
			$stmt2 -> execute([$l]); 
			$stmt3 = $db->prepare("DELETE FROM abilities2 WHERE login = ?");
			$stmt3 -> execute([$l]);
		  }
		  catch(PDOException $e){
			print('Error : ' . $e->getMessage());
			exit();
		  }
		  header('Location: admin.php');
		  exit();
  }
  if(array_key_exists('update', $_POST)){
	$user = 'u47522';
	$pass = '7677055';
	$db = new PDO('mysql:host=localhost;dbname=u47522', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
	$fio = $_POST['fio'];
	$email = $_POST['email'];
	$date = $_POST['date'];
	$gender = $_POST['gender'];
	$arms = $_POST['arms'];
	$about = $_POST['about'];
	try {
		$stmt = $db->prepare("SELECT login FROM heroes2 WHERE id = ?");
		$stmt -> execute([$_POST['uid']]);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$l = $row['login'];
		$stmt2 = $db->prepare("UPDATE heroes2 SET fio = ?, email = ?, date = ?, gender = ?, arms = ?, about = ? WHERE login = ?");
		$stmt2 -> execute([$fio,$email,$date,$gender,$arms,$about,$l]);
		$db->prepare("DELETE FROM abilities2 WHERE login=?")->execute([$l]);
		foreach($_POST['arg'] as $key){
		  $new = $db->prepare("INSERT INTO abilities2(ability,login) VALUES (?,?)");
		  $new -> execute([$key, $l]); 
		}
	  }
	  catch(PDOException $e){
		print('Error : ' . $e->getMessage());
		exit();
	  }
	  header('Location: admin.php');
	  exit();
  }
}