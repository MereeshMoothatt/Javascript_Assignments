<?php 
session_start();
 include('common_util.php');
 if(isset($_POST['submitUserName'])){
    $error = false;
    $txtUserNameError = "";
    if(!empty($_POST['txtUserName'])) {
        $userName = mysqli_real_escape_string($dbc,trim($_POST['txtUserName']));
        if(!(strlen($userName) == 10)) {
            $txtUserNameError = "The length of the user name should be 10.";
            $error = true;
        } else {
            $userDoesExist = doesUserExist($userName,$dbc);
            if (!$userDoesExist) {
                $txtUserNameError = "This user does not exist!";
                $error = true;
            } 
        }
    } else {
        $txtUserNameError = "Please enter your user name.";
        $error = true;
    }
    if ($error == false) {
        $_SESSION['sessionUserNameToUpdate'] = $userName;
        header('Location:edit_user_profile.php');
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
    <script src="dropdown.js"></script> 
     <!--////////////////////////////////////// bootstrap connection/////////////////////////////////// -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!--  ////////////////////////////////////external stylesheet connection////////////////////////// -->
    <link rel="stylesheet" href="master.css"> 
</head>
<body style="background-color:white;">
<div class="container-fluid admdash-sec6-cont " >
<div class="card card-body">
<form method="POST" action="select_edit_user_profile.php" id="selectEditUserProfileForm">
    <table class="table">
        <tr>
            <td>User Name:</td>
            <td><input type="text" name="txtUserName" value="<?php echo $userName ?? null; ?>"></td>
            <td><input  class="btn btn-primary" type="submit" name="submitUserName" id="submit" value="View"></td>
        </tr>
        <tr>
            <td></td>
            <td><span id="error"><?php echo $txtUserNameError ?? null ?></span></td>
            <td></td>
        </tr>
    </table>
    
</form>
</div>
</div> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>