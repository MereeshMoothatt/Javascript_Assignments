"use strict"; 

/* document.addEventListener("DOMContentLoaded", evt => {
  showEdit();
}); */
function showEdit(errorCheck) {
  //var error = document.getElementById("errorCheck").value;
  console.log("I am called :" + error);
  if (errorCheck == false) {
    document.getElementById("editUser").style.visibility = 'visible';
  } else {
    document.getElementById("editUser").style.visibility = 'hidden';
  }
}