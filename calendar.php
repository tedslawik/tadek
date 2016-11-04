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
 
 
 
 
 // Pobieram rok i miesiac dzien
list($iNowYear, $iNowMonth, $iNowDay) = explode('-', date('Y-m-d'));
if (isset($_GET['month'])) {
list($iMonth, $iYear) = explode('-', $_GET['month']);
$iMonth = (int)$iMonth;
$iYear = (int)$iYear;
} else {
list($iMonth, $iYear) = explode('-', date('n-Y'));
}
// przypisanie numerów do dni
$iTimestamp = mktime(0, 0, 0, $iMonth, $iNowDay, $iYear);
list($sMonthName, $iDaysInMonth) = explode('-', date('F-t', $iTimestamp));

////
switch ($sMonthName){
case "January" :
$sMonthName = "Styczen";
break;
case "February" :
$sMonthName = "Luty";
break;
case "March" :
$sMonthName = "Marzec";
break;
case "April" :
$sMonthName = "Kwiecien";
break;
case "May" :
$sMonthName = "Maj";
break;
case "June" :
$sMonthName = "Czerwiec";
break;
case "July" :
$sMonthName = "Lipiec";
break;
case "August" :
$sMonthName = "Sierpien";
break;
case "September":
$sMonthName = "Wrzesień";
break;
case "October":
$sMonthName = "Pazdziernik";
break;
case "November" :
$sMonthName = "listopad";
break;
case "December" :
$sMonthName = "Grudzien";
break;
}
/////
// Poprzedni rok i dzień
$iPrevYear = $iYear;
$iPrevMonth = $iMonth - 1;
if ($iPrevMonth <= 0) {
$iPrevYear--;
$iPrevMonth = 12; // Grudzien
}
// Następny rok 
$iNextYear = $iYear;
$iNextMonth = $iMonth + 1;
if ($iNextMonth > 12) {
$iNextYear++;
$iNextMonth = 1;
}
// Dni z poprzedniego miesiąca
$iPrevDaysInMonth = (int)date('t', mktime(0, 0, 0, $iPrevMonth, $iNowDay, $iPrevYear));
// Pierszy dzien miesiąca
$iFirstDayDow = (int)date('w', mktime(0, 0, 0, $iMonth, 1, $iYear));
// Pierwszy dzień poprzedniego miesiaca
$iPrevShowFrom = $iPrevDaysInMonth - $iFirstDayDow + 1;
// Warunek poprzedniego miesiąca
$bPreviousMonth = ($iFirstDayDow > 0);
$iCurrentDay = ($bPreviousMonth) ? $iPrevShowFrom : 1;
$bNextMonth = false;
$sCalTblRows = '';
// Kolumny kalendaża
for ($i = 0; $i < 6; $i++) { // 6tygodni
$sCalTblRows .= '<tr>';
for ($j = 0; $j < 7; $j++) { // 7 dni
$sClass = '';
if ($iNowYear == $iYear && $iNowMonth == $iMonth && $iNowDay == $iCurrentDay && !$bPreviousMonth && !$bNextMonth) {
$sClass = 'today';
} elseif (!$bPreviousMonth && !$bNextMonth) {
$sClass = 'current';
}
$sCalTblRows .= '<td class="'.$sClass.'"><a href="javascript: void(0)">'.$iCurrentDay.'</a></td>';
// nastepny dzien
$iCurrentDay++;
if ($bPreviousMonth && $iCurrentDay > $iPrevDaysInMonth) {
$bPreviousMonth = false;
$iCurrentDay = 1;
}
if (!$bPreviousMonth && !$bNextMonth && $iCurrentDay > $iDaysInMonth) {
$bNextMonth = true;
$iCurrentDay = 1;
}
}
$sCalTblRows .= '</tr>';
}
// generowanie kalendarza 
$aKeys = array(
'__prev_month__' => "{$iPrevMonth}-{$iPrevYear}",
'__next_month__' => "{$iNextMonth}-{$iNextYear}",
'__cal_caption__' => $sMonthName . ', ' . $iYear,
'__cal_rows__' => $sCalTblRows,
);
$sCalendarItself = strtr(file_get_contents('calendar.html'), $aKeys);
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' && isset($_GET['month'])) {
header('Content-Type: text/html; charset=utf-8');
echo $sCalendarItself;
exit;
}
$aVariables = array(
'__calendar__' => $sCalendarItself,
);
echo strtr(file_get_contents('home.php'), $aVariables);
 ?>
