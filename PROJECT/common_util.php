<?php
require('db_config.php');
$passKey =  "enterprise123";

$availabilities = ["Afternoon","All","Morning"];
$userTypes = ["Employee","Admin"];
$userStatus = ["Active","Inactive"];
$days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];

function doesUserExist($userName, $dbc) {
    $sql = "SELECT user_name FROM user";
    $resultSelect = mysqli_query($dbc,$sql);
    $users = mysqli_fetch_all($resultSelect);
    $userDoesExist = False;
    if($users != null) {
        foreach ($users as $user) {
            if (strcasecmp($userName, $user[0]) == 0) {
                $userDoesExist = True;
                break;
            }
        }
    }
    mysqli_free_result($resultSelect);
    return $userDoesExist;
}

function isUserActive($userName, $dbc) {
    $userActive = False;
    $sqlSelect ="SELECT active from user where user_name = ?";
    $stmt = mysqli_prepare($dbc,$sqlSelect);
    mysqli_stmt_bind_param($stmt,'s', $userName);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$active);
    while(mysqli_stmt_fetch($stmt)) {
        if ($active == 1) {
            $userActive = True;
        }
    }
    mysqli_stmt_close($stmt);
    return $userActive;
}

function getUserSchedule($userId, $yearweek, $dbc) {
    $sqlSelect = "SELECT user_id,week,schedule_date,schedule_day,do_work,start_time,end_time,hours FROM schedule where user_id = ? and week = ?";
    $stmt = mysqli_prepare($dbc,$sqlSelect);
    echo mysqli_error($dbc);
    mysqli_stmt_bind_param($stmt,'ii', $userId,$yearweek);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$userId,$week,$scheduleDate,$scheduleDay,$doWork,$startTime,$endTime,$hours);
    $userSchedules = array();
    $my_index = 0;
    while(mysqli_stmt_fetch($stmt)) {
        $userSchedule['user_id'] = $userId; 
        $userSchedule['week'] = $week;
        $userSchedule['schedule_date'] = $scheduleDate;
        $userSchedule['schedule_day'] = $scheduleDay;
        $userSchedule['do_work'] = $doWork;
        $userSchedule['start_time'] = $startTime;
        $userSchedule['end_time'] = $endTime;
        $userSchedule['hours'] = $hours;
        $userSchedules[$my_index] = $userSchedule;
        $my_index = $my_index + 1;
    }
    mysqli_stmt_close($stmt);
    return $userSchedules;
}


function deleteUserSchedule($userId, $yearweek, $dbc) {
    $sql = "DELETE FROM schedule where user_id = $userId and week = $yearweek";
    $deleteStatus = mysqli_query($dbc,$sql);
    return $deleteStatus;
}

function getDayValue($Day) {
    $dayValue = "";

    switch ($Day) {
        case 'Monday':
            $dayValue =date("d/m/Y", strtotime("next Monday"));  
            break; 
        case 'Tuesday':
            $dayValue =date("d/m/Y", strtotime("next Monday". ' + 1 days'));  
            break; 
        case 'Tuesday':
            $dayValue =date("d/m/Y", strtotime("next Monday". ' + 1 days'));  
            break; 
        case 'Wednesday':
            $dayValue =date("d/m/Y", strtotime("next Monday". ' + 2 days'));  
            break;
        case 'Thursday':
            $dayValue =date("d/m/Y", strtotime("next Monday". ' + 3 days'));  
            break;
        case 'Friday':
            $dayValue =date("d/m/Y", strtotime("next Monday". ' + 4 days'));  
            break;
        case 'Saturday':
            $dayValue =date("d/m/Y", strtotime("next Monday". ' + 5 days'));  
            break;
        case 'Sunday':
            $dayValue =date("d/m/Y", strtotime("next Monday". ' + 6 days'));  
            break;  
        default:
        $dayValue = "";
    }
    return $dayValue;
}

?>