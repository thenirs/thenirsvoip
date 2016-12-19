<?php

$mylogin = array('admin','admin2');

$mypasswd = array(
                 'admin' => '1111',
                 'admin2' =>  '22222',
                  );

if ($_POST['login'] && $_POST['password'])
   {
     if (in_array($_POST['login'], $mylogin))
        {
          if($_POST['password'] == $mypasswd[$_POST['login']])
             {
             session_start();
             $_SESSION['good_admin']= 1;
             Header("Location: index.php");
             exit;
             }else{
                   echo "<center><br>Неправильный логин или пароль</center>";
                   }
        }else{
              echo "<center><br>Неправильный логин или пароль</center>";
              }
   }

?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css">
    <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
  <section class="container">
    <div class="login">
      <h1>Войти в личный кабинет</h1>
      <form method="post" action="">
        <p><input type="text" name="login" value="" placeholder="Логин или Email"></p>
        <p><input type="password" name="password" value="" placeholder="Пароль"></p>
                 <p class="submit"><input type="submit" name="commit" value="Войти"></p>
      </form>
    </div>

    <div class="login-help">

    </div>
  </section>
</body>
</html>