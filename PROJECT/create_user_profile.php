<?php

    require('common_util.php');
    // vairable declaration
    $error = false;
    $namePattern = "/[a-zA-Z]{2,30}$/";
    $message = ""; 
    $txtFirstNameError = "";
    $txtLastNameError = "";
    $txtEmailError =  "";
    $txtUserNameError = "";
    $txtCellNumberError ="";
    $txtPasswordError = "";
    $txtConfirmPasswordError = "";
    $firstName = "";
    $lastName ="";
    $email = "";
    $userName = "";
    $cellNumber = "";
    $selectedAvailability = "";
    $selectedUserType = "";
    $password ="";
    $confirmPassword = "";
 if(isset($_POST['submit'])){
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
        $userProfileCreated = False;
        $userDoesExist = doesUserExist($userName,$dbc);
        $encodedPassword = convert_uuencode($password);
        // echo $encodedPassword;
     
        
        if (!$userDoesExist) {
             //Insert Query to insert user data into User Table
            $sqlInsert = "INSERT INTO user(first_name,last_name,user_type,user_name,password,email_id,mobile_number,availability) 
            VALUES(?,?,?,?,?,?,?,?)";
            $stmt = mysqli_prepare($dbc,$sqlInsert);
            mysqli_stmt_bind_param($stmt,'ssssssss',$firstName,$lastName, $selectedUserType, $userName, $encodedPassword, $email, $cellNumber, $selectedAvailability );
            $result = mysqli_stmt_execute($stmt);
            if ($result) {
                $userProfileCreated = True;
                $firstName = "";
                $lastName ="";
                $email = "";
                $userName = "";
                $cellNumber = "";
                $selectedAvailability = "";
                $selectedUserType = "";
                $password ="";
                $confirmPassword = "";
                $message = "User profile is successfully created!";
            }
            mysqli_stmt_close($stmt);

        } else {
            $txtUserNameError = "This user already exists!";
        }
    }
}
mysqli_close($dbc);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <script src="dropdown.js"></script> 
     <!--////////////////////////////////////// bootstrap connection/////////////////////////////////// -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!--  ////////////////////////////////////external stylesheet connection////////////////////////// -->
    <link rel="stylesheet" href="master.css"> 
</head>
<body style="background-color:white;">


<div class="card card-body">
<form method="POST" action="create_user_profile.php" id="createUserProfileForm">
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
            <td><input type="password" name="txtConfirmPassword" value="<?php echo $confirmPassword ?? null; ?>"></td>
            <td><span id="error"><?php echo $txtConfirmPasswordError ?? null ?></span></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input  class="btn btn-primary" type="submit" name="submit" id="submit" value="Create" onclick="getDropDownValues()">
                <input  class="btn btn-primary" type="submit" name="reset" value="Reset">
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