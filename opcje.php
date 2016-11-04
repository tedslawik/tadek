<?php
ob_start();
 session_start();
 require_once 'dbconnect.php';
 
 // if session is not set this will redirect to login page
 if( !isset($_SESSION['user']) ) {
  header("Location: index.php");
  exit;
 }

 // select loggedin users detail
 //$res=mysql_query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
 //$userRow=mysql_fetch_array($res);

 
 $user_name=$_GET['user_name'];
 //$user_id=$_GET['user_id'];
 $pom2 = trim($_GET['user_id']);
 //$pom = strip_tags($user_id);
if( isset($_POST['btn-name']) ) { 

    
    $newname = trim($_POST['newname']);
  $newname = strip_tags($newname);
  $newname = htmlspecialchars($newname);
  
     
     
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
  
  $user_id=$_GET['user_id'];
 $query = "UPDATE users SET userName='$newname' WHERE userId='$pom2' ";
 $res = mysql_query($query);
  
  
 unset($newname); 
  
  if( !$error ) {
   if ($res) {
    $errTyp = "success";
    $errMSG = "Imie zmieniono";
   } else {
    $errTyp = "danger";
    $errMSG = "Coś nie tak przy name..."; 
          }   
   }
  
  
  
} 
if( isset($_POST['btn-pass']) ) {
      
   $pass2 = trim($_POST['pass2']);
  $pass2 = strip_tags($pass2);
  $pass2 = htmlspecialchars($pass2);

  if (empty($pass2)){
   $error = true;
   $passError = "Wprowadź swoje nowe hasło.";
  } else if(strlen($pass2) < 3) {
   $error = true;
   $passError = "Hasło musi mieć conajmniej 3 znaki.";
  } 
  $pass2n = hash('sha256', $pass2);
  
  $query = "UPDATE users SET userPass='$pass2n' WHERE userId='$user_id'";
   $res = mysql_query($query);
  
   
   
   if( !$error ) {
   if ($res) {
    $errTyp = "success";
    $errMSG = "hasło zmieniono ";
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
<title>Edycja profilu-admin></title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
<span class=""></span>Panel edycji dla użytkownika : <?php echo $pom2; ?>
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
<body>
     <div class="form-group">
<input type="newname" name="newname" class="form-control" placeholder="Nowe imie dla uzytkownika" value="<?php echo $newname; ?>" maxlength="40" />
          <span class="text-danger"><?php echo $nameError; ?></span>
         </div>
          <div class="form-group">
             <button type="submit" class="btn btn-block btn-primary" name="btn-name">Zamień imię </button>
             
             </div>
    
    
    
     <div class="form-group">
            <input type="password" name="pass2" class="form-control" placeholder="Twóje nowe hasło" value="<?php echo $pass2; ?>" maxlength="40" />
            <div class="form-group">
            <button type="submit" class="btn btn-block btn-primary" name="btn-pass">Zamień hasło</button>
            <span class="text-danger"><?php echo $passError; ?></span>
          </div>
           <hr/>
<a href="home.php">Weź wróć ...</a>
</body>
</html>