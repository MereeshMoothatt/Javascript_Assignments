<?php

session_start();
require('common_util.php');

if($_SESSION['userName']== null)
{
    header('location: home.php');
} 
//if user tries to change url to access admin page.
if($_SESSION['userType'] == "Admin")
{
    header('location:admindash.php');
}

////////////////// Date dynamic filling////////////////////////////////////
date_default_timezone_set("Canada/Eastern");
$sysToday = getdate();
$weekDay = $sysToday['wday'];
$upcomingWeekDate = new DateTime(strval(date("Y-m-d", strtotime("+7 days")))); 
$upcomingWeek = $upcomingWeekDate->format("W");
$upcomingYear = $upcomingWeekDate->format("Y");
$yearweek = $upcomingYear.$upcomingWeek;

$userAvailability = $_SESSION['availability'];


// get week day number of the currentweek for eg; Monday = 1
if(intval($weekDay) === 1) {
    $currentMonday = date("Y-m-d");
} 
else {
    $currentMonday = date("Y-m-d", strtotime("previous Monday"));
}
$userId = intval($_SESSION['userId']);
$userSchedules = getUserSchedule($userId, $yearweek, $dbc);

if(sizeof($userSchedules)>0)  {
    $schedule = 'Reschedule';
} else {
    $schedule = 'Schedule';
}
//////////////////////////////////////////////////////////////////////////
if (isset($_POST['schedule'])) {
    $userId = intval($_SESSION['userId']);
    $weekArray = array();
    $my_index = 0;
    foreach($days as $Day) {
        $dayValue = getDayValue($Day);
        $day = strtolower($Day);
        $dayDoWorkText = $day.'DoWork';
        $shiftStartTimeTextValue = "";
        $shiftEndTimeTextValue = "";
        $dayHoursTextValue = "";
        $dayScheduledHoursTextValue = "";
        if(isset($_POST[$dayDoWorkText])) {
            $dayDateText = $day.'Date';
            $shiftStartTimeText = $day.'ShiftStartTime';
            $shiftEndTimeText = $day.'ShiftEndTime';
            $dayHoursText = $day.'Hours';
            $shiftStartTimeTextValue = trim($_POST[$shiftStartTimeText]);
            $shiftEndTimeTextValue = trim($_POST[$shiftEndTimeText]);
            $dayHoursTextValue = trim($_POST[$dayHoursText]);
            $dayArray = $day.'Array';
            $dayArray = array($userId,$yearweek,$dayValue,$Day,true,$shiftStartTimeTextValue,$shiftEndTimeTextValue,$dayHoursTextValue);
            $weekArray[$my_index] = $dayArray;
            $my_index = $my_index + 1;
        }
    }


    if($schedule == 'Reschedule') {
        deleteUserSchedule($userId, $yearweek, $dbc);
    }
    if (count($weekArray) > 0) {
        $sqlInsert = "INSERT INTO schedule(user_id,week,schedule_date,schedule_day,do_work,start_time,end_time,hours) VALUES (?,?,STR_TO_DATE(?, '%d/%m/%Y'),?,?,?,?,?)";
        $stmt = mysqli_prepare($dbc,$sqlInsert);
         for ($day = 0; $day <count($weekArray); $day++) {
                echo "Row : ".$day;
                echo '<br>';
                $userId = $weekArray[$day][0];
                $week =  $weekArray[$day][1];
                $scheduleDate =  $weekArray[$day][2];
                $scheduleDay =  $weekArray[$day][3];
                $doWork =  $weekArray[$day][4];
                $startTime =  $weekArray[$day][5];
                $endTime =  $weekArray[$day][6];
                $hours =  $weekArray[$day][7];
                //echo $userId.' '.$week.' '.$scheduleDate.' '.$scheduleDay.' '.$doWork.' '.$startTime.' '.$endTime.' '.$hours;
                //echo '<br>';
                mysqli_stmt_bind_param($stmt,'iississs',$userId,$week,$scheduleDate,$scheduleDay,$doWork,$startTime,$endTime,$hours);
                mysqli_stmt_execute($stmt);
        } 
        header('Refresh:0');
        mysqli_stmt_close($stmt);
    }   
}
 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!--////////////////////////////////////// bootstrap connection/////////////////////////////////// -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!--  ////////////////////////////////////external stylesheet connection////////////////////////// -->
    <link rel="stylesheet" href="master.css"> 
    <title>Employee Dash</title>
</head>
<body>
<form action="employeedash.php" method="POST">
    <div class="container-fluid employeedash-container">
         <!-- first section thast contains header and the logout button -->
        <section id="section1">
            <nav class="navbar navbar-expand-large">
                <nav class="container-fluid navbarfluidcontainer">
                    <h3 class="navbar-brand">Dashboard</h3>
                    <ul class="navbar-nav ms-auto">
                        <li>
                        <button type="button" class="btn btn-primary" onclick="logoutFunction();">Logout</button>
                        </li>
                    </ul>
                </nav>
            </nav>
        </section>

        <!-- section that contains the employee user details -->
        <section id="section2">
            <div class="container-fluid section2-container">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="inline-txt">Employee User Name: </h6><span ><?php echo $_SESSION['userName']; ?></span>   
                    </div>
                    <div class="col-md-6">
                        <h6  class="inline-txt">Upcoming Week: </h6><?php echo $upcomingWeek ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="inline-txt">Employee Full Name: </h6><?php echo $_SESSION['userFullName']; ?>
                    </div>
                    <div class="col-md-6">
                        <h6 class="inline-txt">Upcoming Week From: </h6><?php echo date("d/m/Y", strtotime("next Monday")); ?>
                        <h6 class="inline-txt">to: </h6><?php echo date("d/m/Y", strtotime("next Monday". ' + 6 days'))?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="inline-txt">Employee Availability: </h6><span id="availabilitySpan"><?php echo $userAvailability ?></span>
                    </div>
                </div>
            </div>
        </section>
        <br>

        <!-- section that contains the schedule panel -->
        <section id="section3">
            <div class="container-fluid section3-container">
                <!-- header container   -->
                <div class="container-fluid section3-innercontainer1">
                    <div class="row section3-row1">
                        <div class="col-md-1">
                            <h6>Day</h6>
                        </div>
                        <div class="col-md-2">
                            <h6>Date</h6>
                        </div>

                        <div class="col-md-1">
                            <h6>Do work?</h6>
                        </div>
                        <div class="col-md-2">
                            <h6>Start Time</h6>
                        </div>
                        <div class="col-md-1">
                            <h6>End Time</h6>
                        </div>
                        <div class="col-md-2">
                            <h6>Hours</h6>
                        </div>
                        <div class="col-md-2">
                            <h6>Current Schedule</h6>
                        </div>
                    </div>
                </div>
                <br>
<?php 

foreach($days as $Day) {
    $dayValue = getDayValue($Day);
    $day = strtolower($Day);
    $dayDateText = $day.'Date';
    $shiftStartTimeText = $day.'ShiftStartTime';
    $shiftEndTimeText = $day.'ShiftEndTime';
    $dayDoWorkText = $day.'DoWork';
    $dayHoursText = $day.'Hours';
    $dayScheduledHoursText = $day.'ScheduledHours';
    $shiftStartTimeTextValue = "";
    $shiftEndTimeTextValue = "";
    $dayHoursTextValue = "";
    $dayScheduledHoursTextValue = "";
    if(sizeof($userSchedules)>0) {
        foreach ($userSchedules as $userSchedule) {
            if ($Day == $userSchedule['schedule_day']) {
                $shiftStartTimeTextValue = $userSchedule['start_time'];
                $shiftEndTimeTextValue = $userSchedule['end_time'];
                $dayHoursTextValue = $userSchedule['hours'];
                $dayScheduledHoursTextValue = $shiftStartTimeTextValue .'-'.$shiftEndTimeTextValue .' ('. $dayHoursTextValue.' Hours)';
                break;
            }
        }
    }
?>
                <div class="container-fluid section3-innercontainer2">
                    <div class="row section3-row2">
                        <div class="col-md-1">
                            <p><?php echo $Day ?></p>
                        </div>
                        <div class="col-md-2">
                            <p class="Section3-res-element-under780">Date: </p>
                            <input type="text" class="date" name="<?php echo $dayDateText ?>" value="<?php echo $dayValue ?>" disabled>
                        </div>
                  
                        <div class="col-md-1">
                            <p class="Section3-res-element-under780">Do Work: </p>
                            <input type = "checkbox" id="<?php echo $dayDoWorkText ?>" name="<?php echo $dayDoWorkText ?>" onclick="populateStartTime(document.getElementById('availabilitySpan'),document.getElementById('<?= $shiftStartTimeText ?>'), document.getElementById('<?= $shiftEndTimeText ?>'), document.getElementById('<?= $dayDoWorkText ?>'), document.getElementById('<?= $dayHoursText ?>'))">
                        </div>

                        <div class="col-md-2">
                            <p class="Section3-res-element-under780">Start Time: </p>
                            <select id="<?php echo $shiftStartTimeText ?>" name = "<?php echo $shiftStartTimeText ?>" onchange="populateEndTime(this,document.getElementById('<?= $shiftEndTimeText ?>'), document.getElementById('<?= $dayHoursText ?>'))" disabled>
                            </select>
                        </div>
                     
                        <div class="col-md-1">
                            <p class="Section3-res-element-under780">End Time: </p>
                            <select id="<?php echo $shiftEndTimeText ?>" name = "<?php echo $shiftEndTimeText ?>" onclick = "calculateHours(document.getElementById('<?= $shiftStartTimeText ?>'), this, document.getElementById('<?= $dayHoursText ?>'))" disabled>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <p class="Section3-res-element-under780">Hours: </p>
                            <input type="text" name="<?php echo $dayHoursText ?>" id="<?php echo $dayHoursText ?>" readonly = "readonly">
                        </div>
                        <div class="col-md-2">
                            <p class="Section3-res-element-under780">Current Schedule: </p>
                            <input type="text" name="<?php echo $dayScheduledHoursText ?>" id="<?php echo $dayScheduledHoursText ?>"  value="<?php echo $dayScheduledHoursTextValue ?? null; ?>" disabled>
                        </div>
                    </div>
                </div> 
                <?php
}
?>
            </div> 
        </section> 
        <br> 

        <!-- section that cotains total hours and save and edit buttons -->
        <section id="section4">
            <div class="container-fluid section4-container">
                <div class="row">
                    <div class="col-md-8">
                        
                    </div>
                    <div class="col-md-4">
                        <input type="submit" name="schedule" value="<?php echo $schedule ?? null; ?>" class="btn btn-primary">  
                    </div>
                </div>
            </div>
        </section>

    </div>
</form>
    <!-- /////////////////////////////////////bootstrap javascript connection////////////////////////// -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <!-- /////////////////////////////////value population js file connection/////////////////////////////// -->
    <script src="populateValues.js"></script>
    <script src="logout.js"></script>
                               
</body>
</html>