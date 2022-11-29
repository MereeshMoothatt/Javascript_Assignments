<?php
session_start();
include('common_util.php');
if(isset($_POST['submitAvailability'])){
    $selectedAvailability ="";
    $selectedUserType = "";
    $selectedUserStatus = "";
    if(!empty($_POST['availabilitySelect'])){
        $selectedAvailability = $_POST['availabilitySelect'];
    }
    if(!empty($_POST['userTypeSelect'])){
        $selectedUserType = $_POST['userTypeSelect'];
    }
    if(!empty($_POST['userStatusSelect'])){
        $selectedUserStatus = $_POST['userStatusSelect'];
    }
    $_SESSION['sessionSelectedAvailability'] = $selectedAvailability;
    $_SESSION['sessionSelectedUserType'] = $selectedUserType;
    $_SESSION['sessionSelectedUserStatus'] = $selectedUserStatus;
    header('Location:view_employee_details.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <script src="dropdown.js"></script> 
     <!--////////////////////////////////////// bootstrap connection/////////////////////////////////// -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!--  ////////////////////////////////////external stylesheet connection////////////////////////// -->
    <link rel="stylesheet" href="master.css"> 
</head>
<body  style="background-color:white;">
<div class="container-fluid admdash-sec2-cont">
<div class="card card-body">
    <form action="select_view_employee_details.php" method="POST">
        <table class="table">
        <tr>
            <td class="selectFormTableColumn">Select Availability:</td>
            <td class="selectFormTableColumn"><select name="availabilitySelect" id="availabilitySelect">
                    <?php
                            foreach($availabilities as $availability) {
                                echo '<option>' . $availability . '</option>';
                            }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="selectFormTableColumn">Select User Type:</td>
            <td class="selectFormTableColumn"><select name="userTypeSelect" id="userTypeSelect">
                    <?php
                            foreach($userTypes as $userType) {
                                echo '<option>' . $userType . '</option>';
                            }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="selectFormTableColumn">Select User Status:</td>
            <td class="selectFormTableColumn"><select name="userStatusSelect" id="userStatusSelect">
                    <?php
                            foreach($userStatus as $userStat) {
                                echo '<option>' . $userStat . '</option>';
                            }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td></td>
            <td><input  class="btn btn-primary" type="submit" name="submitAvailability" id="submitAvailability" value="View"></td>
        </tr>
        </table>
    </form>
</div>
</div> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>