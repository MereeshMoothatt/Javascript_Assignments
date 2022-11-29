

function logoutFunction(){
  var reallyLogout=confirm("Do you really want to log out?");
  if(reallyLogout)
  {
    location.href = "logout.php";
  }
}

