<?php
session_start();
include('common_util.php');
$sessionAvailability = $_SESSION['sessionSelectedAvailability'];
$selectedUserType = $_SESSION['sessionSelectedUserType'];
$selectedUserStatus = $_SESSION['sessionSelectedUserStatus'];

$active = 0;
if($selectedUserStatus == 'Active') {
    $active = 1;
}

    $sqlSelect ="SELECT first_name,last_name, user_name, availability, email_id, mobile_number from user where availability = ? and user_type = ?  and active = ? ";
    $stmt = mysqli_prepare($dbc,$sqlSelect);
    mysqli_stmt_bind_param($stmt,'ssi', $sessionAvailability,$selectedUserType,$active);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$firstName,$lastName,$userName,$availability,$emailId,$mobileNumber);
    
   


if(isset($_POST['GoBack'])){
    $_SESSION['sessionSelectedAvailability'] = "";
    header('Location:select_view_employee_details.php');
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
<div class="card card-body">
    <form action="view_employee_details.php" method="POST">
    <table class="table">
        <tr>
            <th class="viewEmployeeTableHeader">Employee Name</th>
            <th class="viewEmployeeTableHeader">User Name</th>
            <th class="viewEmployeeTableHeader">Availability</th>
            <th class="viewEmployeeTableHeader">Email</th>
            <th class="viewEmployeeTableHeader">Mobile Number</th>
        </tr>
        
        <?php
         while(mysqli_stmt_fetch($stmt)) {
        ?>
        <tr>
        <td><?php echo $firstName.' '.$lastName ?></td>
        <td><?php echo $userName ?></td>
        <td><?php echo $availability ?></td>
        <td><?php echo $emailId ?></td>
        <td><?php echo $mobileNumber ?></td>
        </tr>
        <?php   
        }
        ?>
        
        <tr>
            <td><input class="btn btn-primary goBackButton" type="submit" name="GoBack" value="Go Back"></td>
        </tr>
    </table>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>