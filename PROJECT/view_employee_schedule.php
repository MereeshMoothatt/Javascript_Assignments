<?php

    session_start();
    include('common_util.php');

    date_default_timezone_set("Canada/Eastern");
    $sysToday = getdate();
    $weekDay = $sysToday['wday'];

    $upcomingWeekDate = new DateTime(strval(date("Y-m-d"))); 
    $upcomingWeek = $upcomingWeekDate->format("W");
    $upcomingYear = $upcomingWeekDate->format("Y");
    $yearweek = $upcomingYear.$upcomingWeek;
  
    if(intval($weekDay) === 1) {
        $currentMonday = date("Y-m-d");
    } else {
        $currentMonday = date("Y-m-d", strtotime("previous Monday"));
    }
    $stringCurrentMonday = strval($currentMonday);
    $weekFromDate =  date("d/m/Y", strtotime($stringCurrentMonday. ' + 0 days'));
    $weekToDate = date("d/m/Y", strtotime($stringCurrentMonday. ' + 6 days'));

    $availability = $_SESSION['sessionSelectedAvailability'];
   

    $sqlSelectQuery = "SELECT s.user_id, s.schedule_day, s.start_time, s.end_time, s.hours, u.first_name, u.last_name FROM schedule s inner join user u on s.user_id =u.user_id WHERE week = ? and u.availability= ?" ;
    $stmt = mysqli_prepare($dbc,$sqlSelectQuery);
    mysqli_stmt_bind_param($stmt,'is', $yearweek, $availability);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$userID,$scheduleDay,$startTime,$endTime,$hours, $firstName, $lastName);

    $userScheduleArray = array();
    $userHoursArray = array();
    $userNames = array();
    while(mysqli_stmt_fetch($stmt))
    {
        $scheduleTime = "";
        $userNames[$userID] = $firstName.' '.$lastName;
        if($scheduleDay != null) {
            $dayScheduleTime = $scheduleDay.'ScheduleTime';
            $dayHours = $scheduleDay.'Hours';
            $scheduleTime = $startTime.'-'.$endTime.'('.$hours.')';
            $userScheduleArray[$userID][$dayScheduleTime] = $scheduleTime;
            $userHoursArray[$userID][$dayHours] = $hours;
        }
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!--////////////////////////////////////// bootstrap connection/////////////////////////////////// -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!--////////////////////////////////////external stylesheet connection////////////////////////// -->
    <link rel="stylesheet" href="master.css"> 
</head>
<body style="background-color:white;">

<section id="viewemployeeschedule">
                    <!-- collpasing content space -->
                        <div class="card card-body">
                           <div class="row">
                                <div class="col-md-12">
                                    <p class="inline-txt"><b>Week:</b> </p>      <?php echo $upcomingWeek ?>
                                </div>
                                <div class="col-md-12">
                                    <p class="inline-txt"><b>Date From:</b> </p> <?php echo $weekFromDate ?>
                                    <p class="inline-txt"><b>to:</b> </p>        <?php echo $weekToDate ?>
                                </div>
                                
                           </div> 
                            
                            
                            
                        </div>
                        <br>
                        <div class="card card-body">
                            <table class="table">
                                <tr>
                                    <th class="viewEmployeeScgeduleTableHeader">Employee Name</th>
                                    <?php
                                    foreach ($days as $Day) {
                                    ?>
                                        <th class="viewEmployeeScgeduleTableHeader"><?php echo $Day ?></th> 
                                    <?php 
                                    }
                                    ?>
                                    <th class="viewEmployeeScgeduleTableHeader">Hours</th>
                                </tr>
                                <?php
                                    foreach (array_keys($userScheduleArray) as $userId) {
                                        $totalHours = 0;
                                    ?>
                                    <tr>
                                        <td><?php echo $userNames[$userId] ?? null ?></td>
                                    <?php
                                        foreach ($days as $Day) {
                                            $dayHours = $Day.'Hours';
                                            $dayScheduledTime = $Day.'ScheduleTime';
                                            $dayTime = $userHoursArray[$userId][$dayHours] ?? null;
                                            if ($dayTime != null) {
                                                $totalHours += floatval($dayTime);
                                            }
                                        ?>
                                    <td><?php echo $userScheduleArray[$userId][$dayScheduledTime] ?? null ?></td>
                                        <?php
                                        }
                                        $totalTime = $totalHours;
                                    ?>
                                    <td><?php echo $totalTime ?? null ?></td>
                                    </tr>
                                    <?php
                                    }
                                ?> 
                            </table>
                        </div>
                    
            </nav>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>