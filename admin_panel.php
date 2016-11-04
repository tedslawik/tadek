<?php

ob_start();
 session_start();
 require_once 'dbconnect.php';
  $error = false;
 // if session is not set this will redirect to login page
 if( !isset($_SESSION['user']) ) {
  header("Location: home.php");
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
   
    
    <a><span class=""></span>&nbsp;Witaj <?php echo $userRow['userEmail']; ?>&nbsp;<span class=""></span></a>
   
    <p>
        <a href='admin_panel.php?type=user' > Użytkownicy</a>       
    </p>
    
  <?php
  if (isset($_GET['type'])&&!empty(['type']))
  {
      ?>
    <table>
        
        <tr><td width='150px'>Uzytkownicy</td></tr>
   <?php
   $list_query = mysql_query("SELECT * FROM users ");
   while($user_list=  mysql_fetch_array($list_query))
   {
       $user_id=$user_list['userId'];
       $user_name=$user_list['userName'];
       $user_email=$user_list['user_Email'];
       
       ?>
        <tr><td><?php echo$user_id ?><?php echo " : "?><?php echo $user_name?></td><td>
          <?php      
                echo"<a href='opcje.php?user_id=$user_id&user_name=$user_name'> Wybierz go</>";
      ?>
               </td></tr>
         <?php     
         
   }
   ?>
   
    
    </table>
        
    
    
    
    
    <?php
      
  }   
    else
    
        echo "wybierz Użytkownicy by wyswietlic";
        
    
    
    ?>
    
    <hr>
    <a href="home.php">Weź wróć ...</a>
    
</body>