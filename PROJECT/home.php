<!-- /////////////////////////////////////////php section/////////////////////////////////////////// -->
<?php
// include the usercheck function
session_start();
include('common_util.php');

// variable declarations
$error = false;
$userName = "";
$password ="";
$txtUserNameError = "";
$txtPasswordError = "";
$passwordValid = "";


if(isset($_POST["submit"]))
{
    if(!empty($_POST['txtUserName'])) {
        $userName = mysqli_real_escape_string($dbc,trim($_POST['txtUserName']));
        if(!(strlen($userName) == 10)) {
            $txtUserNameError = "The length of the user name should be 10.";
            $error = true;
        } 
    } else {
        $txtUserNameError = "Please enter your user name.";
        $error = true;
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


    if($error == false)
    {
        $userLoggedIn = False;
        $userActive = false;
        $PasswordMatch = false;
        $userDoesExist = doesUserExist($userName,$dbc);
        $isUserActive = isUserActive($userName, $dbc);
        if(!$userDoesExist)
        {
            $txtUserNameError = "This user Does not Exist";
        } else {
            if(!$isUserActive) {
                $txtUserNameError = "This user account is no longer active";
            } else {
                $userDetailsQuery = "SELECT user_id,first_name,last_name,user_type,password,availability,email_id,mobile_number,active from user where user_name = ?";
                $stmt = mysqli_prepare($dbc, $userDetailsQuery);
                mysqli_stmt_bind_param($stmt,'s', $userName);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt,$userId,$firstName,$lastName,$userType,$dbEncodedPassword,$availability,$emailId,$mobileNumber,$userActive);
                    while( mysqli_stmt_fetch($stmt)) {
                        // echo $dbPasswordHashValue;
                        $decodedPassword = convert_uudecode($dbEncodedPassword);
                        if(strcmp($password,$decodedPassword) == 0) {
                                $_SESSION['userId'] = $userId;
                                $_SESSION['userName'] = $userName;
                                $_SESSION['userFullName'] = $firstName.' '.$lastName;
                                $_SESSION['availability'] = $availability;
                                $_SESSION['userType'] = $userType;
                                if ($userType == 'Employee') {
                                    header('Location:employeedash.php');
                                } else {
                                    header('Location:admindash.php');
                                }
                        } else {
                           
                            $txtPasswordError = "Incorrect password!";
                        }
                    }
                    mysqli_stmt_close($stmt);
            }
        }

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
    <title>Login</title>
</head>

<body>
<div class="container bodycontainer">
    <div class="row rowclass"  >
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="home.php" id="employeeLoginForm">
                        <table class="table">
                            <tr>
                                <td><h1>Login</h1><br></td>
                            </tr>
                            <tr>
                                 <td>
                                 <label for="txtusername">User Name:</label>
                                 <input type="text" name="txtUserName" required value="<?php echo $userName ?? null; ?>"><br><br>
                                 </td>
                                 <td><span id="error"><?php echo $txtUserNameError ?? null ?></span></td>
                            </tr>
                            <tr>
                                 <td>
                                <label for="txtpassword">Password: &nbsp&nbsp </label>
                                <input type="password" name="txtPassword" required value="<?php echo $password ?? null; ?>"><br><br>
                                </td>
                                <td><span id="error"><?php echo $txtPasswordError ?? null ?></span></td>
                            </tr>
                            <tr>
                                <td>
                                <input class="btn btn-primary" type="submit" value="Login" name="submit">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- /////////////////////////////////////bootstrap javascript connection////////////////////////// -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>
</html>