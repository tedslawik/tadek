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
 $res=mysql_query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
 $userRow=mysql_fetch_array($res);
 
 
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Witam - <?php echo $userRow['userEmail']; ?></title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>

 <nav class="navbar navbar-default navbar-fixed-top">
    
            <li class="dropdown">
              <a href="#" class="" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
     <span class=""></span>&nbsp;Witaj <?php echo $userRow['userEmail']; ?>&nbsp;<span class=""></span></a>
              <ul class="dropdown-menu">
                <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Wyloguj</a></li>
              </ul>
            </li>
         
            
            <div class="form-group">
                <hr/>
                <a href="edit_profile.php">Zmien dane tu ...</a>
            </div>
    </nav> 

 
    
</body>
</html>
<?php ob_end_flush(); ?>