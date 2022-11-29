<?php
    session_start();
    require 'common_util.php';
    $userName = "";
    $userFullName = "";

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //  assigning username value if its not null
if ($_SESSION['userName'] != null) {
    $userName = $_SESSION['userName'];
} else {
    header('location: home.php');
}
if($_SESSION['userType'] == "Employee") {
    header('location:employeedash.php');
}
    // assigning the userfull name ifnot null
if ($_SESSION['userFullName'] != null) {
    $userFullName = $_SESSION['userFullName'];
} 
    

if(isset($_POST['Refresh'])) {
    header('Location:admindash.php');
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
    <title>Admin Dash</title>
  
    
</head>
<body>
<form action="admindash.php" method="POST">
    <nav class="container-fluid admindashcontainer">
        <!-- contains the userdetails and logout button -->
        <!-- section 1 -->
        <section id="section1">
            <nav class="container-fluid admdash-sec1-cont">
                <nav class="navbar navbar-expand-large adminnavbar">
                    <nav class="container-fluid navbarfluidcontainer">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <p class="inline-txt"><b> Admin User Name: </b></p><?php echo $userName; ?>
                            </li>
                            <li class="nav-item">
                                <p class="inline-txt"><b> Admin Full Name: </b></p> <?php echo $userFullName; ?>
                            </li>
                        </ul>
                        <ul class="navbar-nav ms-auto">
                            <li>
                            <input class="btn btn-primary" type="submit" name="Refresh" value="Refresh">
                            <button type="button" class="btn btn-primary" onclick="logoutFunction();" >Logout</button>
                            </li>
                        </ul>
                       
                    </nav>
                </nav>
            </nav>
        </section>
        <br>

        <!-- contains the employee records for usernames -->
        <!-- section 2 -->
        <section id="employeedetailssection">
            <nav class="container-fluid admdash-sec2-cont ">
                <!-- view button that will collapse and opens the content -->
                <button class="btn btn-primary adminDashButtons" type="button" data-bs-toggle="collapse" data-bs-target="#viewemployeedetail" aria-expanded="false" aria-controls="viewemployeedetail">
                    View Employee Details
                </button>
                <br>
                <!-- collpasing content space -->
                <div class="collapse collapse-show" id="viewemployeedetail">
                    <div>
                    <iframe src="select_view_employee_details.php" id="selectViewEmployeeDetails.php"  width="100%" height=400  style="border:none;">
                    </iframe> 
                    </div>
                </div>
            </nav>
        </section>
        <br>

        <!-- continas view employee schedule for the week -->
        <!-- section 3 -->
        <section id="viewemployeeschedule">
            <nav class="container-fluid admdash-sec3-cont ">
                    <button class="btn btn-primary adminDashButtons" type="button" data-bs-toggle="collapse" data-bs-target="#viewemployeescheduletarget" aria-expanded="false" aria-controls="viewemployeescheduletarget">
                        View Employee Schedule
                    </button>
                    <br>
                    <!-- collpasing content space -->
                    <div class="collapse collapse-show" id="viewemployeescheduletarget">
                    <div>
                    <iframe src="select_view_employee_schedule.php" id="selectViewEmployeeschedule.php"  width="100%" height=400  style="border:none;">
                    </iframe> 
                    </div>
                </div>
                    </div>
            </nav>

        </section>
        <br>

        <!-- contains the edit employee schedule for next week -->
        <!-- section 4 -->
        <section id="editemployeeschedule">
            <div class="container-fluid admdash-sec4-cont">
                <!-- view button that will collapse and opens the content -->
                <button class="btn btn-primary adminDashButtons" type="button" data-bs-toggle="collapse" data-bs-target="#editemployeescheduletarget" aria-expanded="false" aria-controls="editemployeescheduletarget">
                        Edit Employee Schedule
                </button>
                <br>
                <!-- collpasing content space -->
                <div class="collapse collapse-show" id="editemployeescheduletarget">

                    <iframe src="select_edit_employee_schedule.php" width="100%" height=1200  style="border:none;">
                    </iframe> 
                </div>
            </div>
        </section>
        <br>

        <!-- contains edit employee profile for management -->
        <!-- section 5 -->
        <section id="editemployeeprofile">
            <div class="container-fluid admdash-sec5-cont ">
            <!-- <p class="inlinePelement">Edit User Profile</p> -->
                <!-- view button that will collapse and opens the content -->
                <button class="btn btn-primary adminDashButtons" type="button" data-bs-toggle="collapse" data-bs-target="#edituserprofiletarget" aria-expanded="false" aria-controls="edituserprofiletarget">
                            Edit User Profile
                </button>
                      
                <!-- collpasing content space -->
                <div class="collapse collapse-show" id="edituserprofiletarget">
                  
                       <iframe src="select_edit_user_profile.php" width="100%" height="600" style="border:none;">
                       </iframe>

                </div>
            </div>
        </section>
        <br>

        <!-- contains create new user profiles for the management -->
        <!-- section 6 -->
        <section id="createnewuserprofile">
            <div class="container-fluid admdash-sec6-cont " >
                <!-- <p class="inlinePelement">Create User Profile</p> -->
                <!-- view button that will collapse and opens the content -->
                <button class="btn btn-primary adminDashButtons" type="button" data-bs-toggle="collapse" data-bs-target="#createemployeeprofiletarget" aria-expanded="false" aria-controls="createemployeeprofiletarget">
                        Create User Profile
                </button>
                <!-- collpasing content space -->

                <div class="collapse collapse-show" id="createemployeeprofiletarget">
                    <div>
                    <iframe src="create_user_profile.php" id="createUserProfile"  width="100%" height=600  style="border:none;">
                    </iframe> 
                    </div>   
                </div>
                
            </div>
        </section>
    </nav>
    <!-- /////////////////////////////////////bootstrap javascript connection////////////////////////// -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="logout.js"></script>
    <!-- onload="this.style.height=(this.contentWindow.document.body.scrollHeight + 300 )+'px';" -->
</form>
</body>
</html>
