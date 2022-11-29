"use strict";

const $ = selector => document.querySelector(selector);

function availabilitySelectedValue(){
    $("#availabiltyText").value = $("#availabilitySelect").value;
}

function userTypeSelectedValue(){
    $("#userTypeText").value = $("#userTypeSelect").value;
}

//This is to retain selected drop down values after every submit
function getDropDownValues() {
    var availSelect = document.getElementById("availabilitySelect");
   $("#availabiltyText").value = availSelect.options[availSelect.selectedIndex].text;
    var availUserType = document.getElementById("userTypeSelect");
    $("#userTypeText").value = availUserType.options[availUserType.selectedIndex].text;
}

/* document.addEventListener("DOMContentLoaded", () => {
    $("#submit").addEventListener("click", getDropDownValues);
}); */
