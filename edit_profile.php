<?php

ob_start();
 session_start();
 require_once 'dbconnect.php';
 
 // if session is not set this will redirect to login page
 if( !isset($_SESSION['user']) ) {
  header("Location: home.php");
  exit;
 }
 // select loggedin users detail
 $res=mysql_query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
 $userRow=mysql_fetch_array($res);
 
 if( isset($_POST['btn-name']) ) { 
     
  $newname = trim($_POST['newname']);
  $newname = strip_tags($newname);
  $newname = htmlspecialchars($newname);
 // $oldname=$userRow['userName'];
  
     
     
    if (empty($newname)) {
   $error = true;
   $nameError = "Wpisz swoje imię.";
  } else if (strlen($newname) < 3) {
   $error = true;
   $nameError = "Imię musi zawierać conajmniej 3 znaki.";
  } else if (!preg_match("/^[a-zA-Z ]+$/",$newname)) {
   $error = true;
   $nameError = "Imie nie zawiera liczb.";
   
  }
  
   
 $query = "UPDATE users SET userName=('$newname') WHERE userId=".$_SESSION['user'];
 $res = mysql_query($query);
  
  
 unset($newname); 
  
  if( !$error ) {
   if ($res) {
    $errTyp = "success";
    $errMSG = "Imie zmieniono ";
   } else {
    $errTyp = "danger";
    $errMSG = "Coś nie tak..."; 
          }   
   }
  
  
  
}  
  if( isset($_POST['btn-pass']) ) {
      
   $pass2 = trim($_POST['pass2']);
  $pass2 = strip_tags($pass2);
  $pass2 = htmlspecialchars($pass2);
  
  $pass1 = trim($_POST['pass1']);
  $pass1 = strip_tags($pass1);
  $pass1 = htmlspecialchars($pass1);
  
  
  
  
  if (empty($pass2)){
   $error = true;
   $passError = "Wprowadź swoje nowe hasło.";
  } else if(strlen($pass2) < 3) {
   $error = true;
   $passError = "Hasło musi mieć conajmniej 3 znaki.";
  } 
   if(empty($pass1)){
   $error = true;
   $passError = "Wpisz stare hasło!!!.";
  }
   $passold = hash('sha256', $pass1);
   $pass2n = hash('sha256', $pass2);
   
   $res=mysql_query("SELECT userId, userName, userPass FROM users WHERE userId=".$_SESSION['user']);
   $row=mysql_fetch_array($res);
   $count = mysql_num_rows($res);
   
  if( $count == 1 && $row['userPass']==$passold ) { 
      
      
    $_SESSION['user'] = $row['userId'];
   $query = "UPDATE users SET userPass=('$pass2n') WHERE userId=".$_SESSION['user'];
   $res = mysql_query($query);

    
    
    
   } else {
    $errMSG = "Błędne stare hasło";
   
   }

   if( !$error ) {
   
    
   if ($res) {
    $errTyp = "success";
    $errMSG = "Gicior za 5 sekund zostaniesz przekierowany, zaloguj sie ponownie1";
    $nameError = "Gicior za 5 sekund zostaniesz przekierowany, zaloguj sie ponownie";
    
    sleep(5);
    unset($_SESSION['user']);
  session_unset();
  session_destroy();
  header("Location: index.php");
  exit;
   } else {
    $errTyp = "danger";
    $errMSG = "Coś nie tak..."; 
   } 
    
  }
  
  
  }
?>


<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edycja profilu></title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>

<body>
     <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    
     <h2>Edycja profilu dla - <?php echo $userRow['userEmail']?></h2>
     <h3>Imię -   <?php echo $userRow['userName']?></h3>
     <div class="form-group">
      <?php
   if ( isset($errMSG) ) {
    
    ?>
    <div class="form-group">
             <div class="alert alert-danger">
                  <div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
             </div>
                <?php
   }
   ?>
     
     </div>
      <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
          <input type="newname" name="newname" class="form-control" placeholder="Twoje nowie imie" value="<?php echo $newname; ?>" maxlength="40" />
          <div>
          <span class="text-danger"><?php echo $nameError; ?></span>
             <div class="form-group">
             <button type="submit" class="btn btn-block btn-primary" name="btn-name">Zamień</button>
             
             </div>
             
             <hr/>
      </div>
      
      
     <div class="form-group">
            <input type="password" name="pass1" class="form-control" placeholder="Twóje stare hasło" value="<?php echo $pass1; ?>" maxlength="40" />
            <input type="password" name="pass2" class="form-control" placeholder="Twóje nowe hasło" value="<?php echo $pass2; ?>" maxlength="40" />
            <div class="form-group">
            <button type="submit" class="btn btn-block btn-primary" name="btn-pass">Zamień</button>
            
          </div>
             <span class="text-danger"><?php echo $passError; ?></span>
            <hr/>
            
            <a href="home.php">Weź wróć ...</a>
      </div>
    
</body>