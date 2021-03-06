<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';
 
 // it will never let you open index(login) page if session is set
 if ( isset($_SESSION['user'])!="" ) {
  header("Location: home.php");
  exit;
 }
 
 $error = false;
 
 if( isset($_POST['btn-login']) ) { 
  
  
  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);
  
  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);
  
  
  if(empty($email)){
   $error = true;
   $emailError = "Wpisz swój email.";
  } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
   $error = true;
   $emailError = "Wpisz poprawnie email.";
  }
  
  if(empty($pass)){
   $error = true;
   $passError = "Wpisz hasło.";
  }
  
  ///////logowanie
  if (!$error) {
   
   $password = hash('sha256', $pass); // haszowanie SHA256
  
   $res=mysql_query("SELECT userId, userName, userPass FROM users WHERE userEmail='$email'"); //// mysql ecape
   $row=mysql_fetch_array($res);
   $count = mysql_num_rows($res);
   
   if( $count == 1 && $row['userPass']==$password ) {
    $_SESSION['user'] = $row['userId'];
    header("Location: home.php");
   } else {
    $errMSG = "Błędny login lub hasło, spróbój ponownie";
   }
    
  }
  
 }
?>
<!DOCTYPE html>
<html>
<head>

<title>Projekt strony</title>

</head>
<body>

<div class="container">

 <div id="login-form">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    
     <div class="col-md-12">
        
         <div class="form-group">
             <h2 class="">Zaloguj sie.</h2>
            </div>
        
         <div class="form-group">
             <hr />
            </div>
            
            <?php
   if ( isset($errMSG) ) {
    
    ?>
    <div class="form-group">
             <div class="alert alert-danger">
    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
             </div>
                <?php
   }
   ?>
            
            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
             <input type="email" name="email" class="form-control" placeholder="Twój email" value="<?php echo $email; ?>" maxlength="40" />
                </div>
                <span class="text-danger"><?php echo $emailError; ?></span>
            </div>
            
           
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
             <input type="password" name="pass" class="form-control" placeholder="Twoje haslo" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $passError; ?></span>
            
            
            <div class="form-group">
             <hr />
            </div>
            
            <div class="form-group">
             <button type="submit" class="btn btn-block btn-primary" name="btn-login">Zaloguj</button>
            </div>
            
            <div class="form-group">
             <hr />
            </div>
            
            
             <a href="register.php">Zarejestruj sie tu ...</a>
           
         <div class="form-group">
             <hr />
            </div>
          
        
        </div>
   
    </form>
    </div> 
   

</div>

</body>
</html>
<?php ob_end_flush(); ?>