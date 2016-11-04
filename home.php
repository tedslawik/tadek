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
 
 $userlev = $userRow['admin'];
 $reslevel=mysql_query("SELECT * FROM admin WHERE id='$userlev'");
 $userlevel=mysql_fetch_array($reslevel);

 

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
              <span class=""></span>Witaj <?php echo $userRow['userEmail']; ?></a>[<?php echo $userlevel['admin_name']; ?>]
              <ul class="dropdown-menu">
              <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Wyloguj</a></li>
              </ul>
            </li>
         
            
            <div class="form-group">
                <hr/>
                <a href="edit_profile.php">Zmien dane tu ...</a>
            </div>
               <div class="form-group"><hr/>
            <?php
            
           if($userRow['admin']==2)
           {
             ?>
                   
             <a href='admin_panel.php'>Panel admina ...</a>
            
              
       <?php
       }
           else
               echo"<a nie jestes adminem </a>"
       ?>
             
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

<!--<title>PHP AJAX Calendar</title>-->

<!-- add styles and scripts -->

<link href="styles.css" rel="stylesheet" type="text/css" />

<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>-->
<hr/>
<div id="calendar">
<a href="calendar.php"/>
__calendar__

</div>
    </nav> 
</body>
</html>
<?php ob_end_flush(); ?>