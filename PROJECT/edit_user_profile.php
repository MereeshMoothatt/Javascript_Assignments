<?php
 session_start();
 require('common_util.php');
 $sessionUserNameToUpdate = $_SESSION['sessionUserNameToUpdate'];
 $userActive = isUserActive($sessionUserNameToUpdate, $dbc);
 //echo $sessionUserNameToUpdate;
 //echo $userActive;
 $userStatus = "Deactivate";
 if (!$userActive) {
    $userStatus = "Activate";
 }
 $message = "";
 $password = "";
 $confirmPassword = "";
 if(isset($_POST['Update'])){
    $error = false;
    $namePattern = "/[a-zA-Z]{2,30}$/";
    $txtFirstNameError = "";
    $txtLastNameError = "";
    $txtEmailError =  "";
    $txtUserNameError = "";
    $txtCellNumberError ="";
    $txtPasswordError = "";
    $txtConfirmPasswordError = "";
    $firstName = "";
    $lastName ="";
    $userName = "";
    $selectedAvailability = "";
    $selectedUserType = "";
    if(!empty($_POST['txtFirstName'])) {
        $firstName = mysqli_real_escape_string($dbc,trim($_POST['txtFirstName']));
        if(!(preg_match($namePattern, $firstName))) {
            $txtFirstNameError = "The name should not contain numbers and the length of name should be minimum 2.";
            $error = true;
        }
    } else {
        $txtFirstNameError = "Please ener your first name.";
        $error = true;
    }
    if(!empty($_POST['txtLastName'])) {
        $lastName = mysqli_real_escape_string($dbc,trim($_POST['txtLastName']));
        if(!(preg_match($namePattern, $lastName))) {
            $txtLastNameError = "The name should not contain numbers and the length of name should be minimum 2.";
            $error = true;
        }
    } else {
        $txtLastNameError = "Please ener your last name.";
        $error = true;
    }
    if(!empty($_POST['txtEmail'])) {
        $email = mysqli_real_escape_string($dbc,trim($_POST['txtEmail']));    
    } else {
        $txtEmailError = "Please enter your email.";
        $error = true;
    }
    if(!empty($_POST['txtUserName'])) {
        $userName = mysqli_real_escape_string($dbc,trim($_POST['txtUserName']));
        if(!(strlen($userName) == 10)) {
            $txtUserNameError = "The length of user name should be 10.";
            $error = true;
        } 
    } else {
        $txtUserNameError = "Please enter your user name.";
        $error = true;
    }
    if(!empty($_POST['txtCellNumber'])) {
        $cellNumber = mysqli_real_escape_string($dbc,trim($_POST['txtCellNumber']));  
    } else {
        $txtCellNumberError = "Please enter your cell number.";
        $error = true;
    }
    if(!empty($_POST['availabiltyText'])) {
        $selectedAvailability = mysqli_real_escape_string($dbc,trim($_POST['availabiltyText']));  
    }
    if(!empty($_POST['userTypeText'])) {
        $selectedUserType = mysqli_real_escape_string($dbc,trim($_POST['userTypeText']));    
    }
    if(!empty($_POST['txtPassword'])) {
        $password = mysqli_real_escape_string($dbc,trim($_POST['txtPassword'])); 
        if (strlen($password) < 7) {
            $txtPasswordError = "The password length should be minimum 7.";
            $error = true;
        }  
    } else {
        $txtPasswordError = "Please enter your password.";
        $error = true;
    }
    if(!empty($_POST['txtConfirmPassword'])) {
        $confirmPassword = mysqli_real_escape_string($dbc,trim($_POST['txtConfirmPassword']));    
        if (strcmp($password, $confirmPassword) !== 0) {
            $txtConfirmPasswordError = "Passwords do not match!";
            $error = true;
        }
    } else {
        $txtConfirmPasswordError = "Please enter again your password to confirm.";
        $error = true;
    }
    if ($error == false) {
        $userProfileUpdated = False;
        $encodedPassword = convert_uuencode($password);
        //Update Query to update user data into User Table
        $sqlUpdate ="UPDATE user SET first_name=?,last_name=?,user_type=?,user_name=?,password=?,email_id=?,mobile_number=?,availability=? Where user_name=?";
        $stmt = mysqli_prepare($dbc,$sqlUpdate);
        mysqli_stmt_bind_param($stmt,'sssssssss',$firstName,$lastName, $selectedUserType, $userName, $encodedPassword, $email, $cellNumber, $selectedAvailability, $sessionUserNameToUpdate);
        $result = mysqli_stmt_execute($stmt);
        if ($result) {
                $userProfileUpdated = True;
                $message = "User profile is successfully updated!";
        }
        mysqli_stmt_close($stmt);
    }
} else {
    $userProfileReturned = False;
    $sqlSelect ="SELECT first_name,last_name,user_type,user_name,password,email_id,mobile_number,availability,active from user where user_name = ?";
    $stmt = mysqli_prepare($dbc,$sqlSelect);
    mysqli_stmt_bind_param($stmt,'s', $sessionUserNameToUpdate);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $firstName, $lastName,$selectedUserType, $userName, $encodedPassword, $email, $cellNumber, $selectedAvailability,$active);
    
    while(mysqli_stmt_fetch($stmt)) {
        //echo $firstName;
        $password = convert_uudecode($encodedPassword); 
         //echo $encodedPassword;
        // echo $password;
    }
    mysqli_stmt_close($stmt);
}

if(isset($_POST['userStatus'])){
    $sqlUpdate ="UPDATE user SET active=? Where user_name=?";
    $active = 0;
    $userStatusUpdated = False;
    if(!$userActive) {
        $userStatus = "Activate";
        $active = 1;
    } else {
        $userStatus = "Deactivate";
        $active = 0;
    }
    $stmt = mysqli_prepare($dbc,$sqlUpdate);
    mysqli_stmt_bind_param($stmt,'is',$active, $sessionUserNameToUpdate);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
            $userStatusUpdated = True;
    }
    header('Refresh:0');
}
if(isset($_POST['GoBack'])){
    $_SESSION['sessionUserNameToUpdate'] = "";
    header('Location:select_edit_user_profile.php');
}

//mysqli_free_result($result);
mysqli_close($dbc);
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
    <!--////////////////////////////////////external stylesheet connection////////////////////////// -->
    <link rel="stylesheet" href="master.css"> 
</head>
<body style="background-color:white;">
<div class="card card-body">
<form method="POST" action="edit_user_profile.php" id="editUserProfileForm">
    <table class="table">
        <tr>
            <td>First Name:</td>
            <td><input type="text" name="txtFirstName" autofocus value="<?php echo $firstName ?? null; ?>"></td>
            <td><span id="error"><?php echo $txtFirstNameError ?? null ?></span></td>
        </tr>
        <tr>
            <td>Last Name:</td>
            <td><input type="text" name="txtLastName" value="<?php echo $lastName ?? null; ?>"></td>
            <td><span id="error"><?php echo $txtLastNameError ?? null ?></span></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><input type="email" name="txtEmail" value="<?php echo $email ?? null; ?>"></td>
            <td><span id="error"><?php echo $txtEmailError ?? null ?></span></td>
        </tr>
        <tr>
            <td>User Name:</td>
            <td><input type="text" name="txtUserName" value="<?php echo $userName ?? null; ?>"></td>
            <td><span id="error"><?php echo $txtUserNameError ?? null ?></span></td>
        </tr>
        <tr>
            <td>Mobile Number:</td>
			<td><input type="text" name="txtCellNumber" value="<?php echo $cellNumber ?? null; ?>" placeholder="1234567890" pattern= "[0-9]{10}"> </td>
            <td><span id="error"><?php echo $txtCellNumberError ?? null ?></span></td>
        </tr>
        <tr>
            <td>Availability:</td>
            <td><select name="availabilitySelect" id="availabilitySelect" onchange="availabilitySelectedValue()">
                    <?php
                            $selectAvail = "";
                            foreach($availabilities as $availability) {
                                if($availability == $selectedAvailability) {
                                 $selectAvail = ' selected';
                                } else {
                                    $selectAvail =""; 
                                }
                                echo '<option value = '.$availability. ' ' .$selectAvail.'>' . $availability . '</option>';
                            }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>User type:</td>
            <td><select name="userTypeSelect" id="userTypeSelect" onchange="userTypeSelectedValue()">
                    <?php
                            $selectUT ="";
                            foreach($userTypes as $userType) {
                                if($userType == $selectedUserType) {
                                 $selectUT = ' selected';
                                } else {
                                    $selectUT =""; 
                                }
                                echo '<option value = '.$userType. ' ' .$selectUT.'>'. $userType .'</option>';
                            }
                    ?>
                </select>
                </td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type="password" name="txtPassword" value="<?php echo $password ?? null; ?>"></td>
            <td><span id="error"><?php echo $txtPasswordError ?? null ?></span></td>
        </tr>
        <tr>
            <td>Confirm Password:</td>
            <td><input type="password" name="txtConfirmPassword" value="<?php echo $password ?? null; ?>"></td>
            <td><span id="error"><?php echo $txtConfirmPasswordError ?? null ?></span></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input class="btn btn-primary" type="submit" name="Update" id="submit" value="Update" onclick="getDropDownValues()">
                <input class="btn btn-primary" type="submit" name="userStatus" value="<?php echo $userStatus ?? null; ?>">
                <input class="btn btn-primary" type="submit" name="GoBack" value="Go Back">
                <input type="hidden" name="availabiltyText" id="availabiltyText" value="">
                <input type="hidden" name="userTypeText" id="userTypeText" value="">
            </td>
        </tr>
        <td></td>
        <td><span id="error"><?php echo $message ?? null ?></span></td>
        <td></td>
    </table>
</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>