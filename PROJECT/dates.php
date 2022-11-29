<?php

$sysToday = getdate();
$weekDay =  $sysToday['wday']; 
global $upcomingWeekOfTheYear;

//Print upcoming week of the year
$strdate =strval(date("Y-m-d"));
$date = new DateTime($strdate);
$currentWeekOfTheYear = $date->format("W");
// Sunday is the start of the new week.
if(intval($weekDay) === 0) {
    $upcomingWeekOfTheYear = $currentWeekOfTheYear;
} else {
    $upcomingWeekOfTheYear = $currentWeekOfTheYear + 1;
}
echo "current week of the year : $currentWeekOfTheYear";
echo "Upcoming Week of the year: $upcomingWeekOfTheYear";
echo '<br>';

//print current day in dd/mm/yyyy format
echo date("d/m/Y");
echo '<br>';


// get week day number of the currentweek for eg; Monday = 1
if(intval($weekDay) === 1) {
    $currentMonday = date("Y-m-d");
} else {
    $currentMonday = date("Y-m-d", strtotime("previous Monday"));
}
echo '<br>';
// Print Current Monday to Sunday
$stringCurrentMonday = strval($currentMonday);
echo date("d/m/Y", strtotime($stringCurrentMonday. ' + 0 days')). "<br/>";
echo date("d/m/Y", strtotime($stringCurrentMonday. ' + 1 days')). "<br/>";
echo date("d/m/Y", strtotime($stringCurrentMonday. ' + 2 days')). "<br/>";
echo date("d/m/Y", strtotime($stringCurrentMonday. ' + 3 days')). "<br/>";
echo date("d/m/Y", strtotime($stringCurrentMonday. ' + 4 days')). "<br/>";
echo date("d/m/Y", strtotime($stringCurrentMonday. ' + 5 days')). "<br/>";
echo date("d/m/Y", strtotime($stringCurrentMonday. ' + 6 days')). "<br/>";


echo '<br>';

//Print Upcoming Monday to Sunday
echo date("d/m/Y", strtotime("next Monday")). "<br/>";
echo date("d/m/Y", strtotime("next Monday". ' + 1 days')). "<br/>";
echo date("d/m/Y", strtotime("next Monday". ' + 2 days')). "<br/>";
echo date("d/m/Y", strtotime("next Monday". ' + 3 days')). "<br/>";
echo date("d/m/Y", strtotime("next Monday". ' + 4 days')). "<br/>";
echo date("d/m/Y", strtotime("next Monday". ' + 5 days')). "<br/>";
echo date("d/m/Y", strtotime("next Monday". ' + 6 days')). "<br/>";


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <input type="text" name="txt" value="<?php echo date("d/m/Y", strtotime("next Monday")); ?>">

</body>
</html>