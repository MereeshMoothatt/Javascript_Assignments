"use strict";

const $ = selector => document.querySelector(selector);

//Variable declarations
var shiftStartingTime, shiftEndingTime;
var shift;
var totalHours;
var lastOptionValue;

//function to remove drop down options
const removeOption = (selectID) => {
    var length = selectID.options.length;
    
        for (var counter = length-1; counter >= 0; counter--) {
            selectID.options[counter] = null;
        }
};


//function to populate end time based on start time 
const populateEndTime = (startSelectID,endSelectID,hoursField) => {
    removeOption(endSelectID);
    var startTime = startSelectID.value;
    var newStartTime = splitTime(startTime);

    newStartTime +=60;
    setShiftStartEndTimes(shift);
    populateTimeInDropdown(newStartTime, shiftEndingTime,endSelectID,endSelectID);

    //Sets default value in shift end time dropdown
    lastOptionValue = endSelectID.options[endSelectID.options.length-1].value;
    endSelectID.value = lastOptionValue;
    calculateHours(startSelectID,endSelectID, hoursField);
};

//function to set start and end time in seconds for both shifts
const setShiftStartEndTimes = (availabilityInnerHTML) => {
    if(!(availabilityInnerHTML == null || shift == " ")) {
        if(availabilityInnerHTML == "Morning") {
            shiftStartingTime = 420;
            shiftEndingTime = 840;
        }
        if(availabilityInnerHTML == "Afternoon") {
            shiftStartingTime = 900;
            shiftEndingTime = 1320;
        }
        if(availabilityInnerHTML == "All") {
            shiftStartingTime = 0;
            shiftEndingTime = 1380;
        }
    }
};

//function to populate values in specific dropdown shift start/endtime
const populateTimeInDropdown = (shiftStartingTime, shiftEndingTime, selectID, endSelectID) => {
    
    if(selectID==endSelectID) {
        shiftEndingTime +=60;
    }

    for(var timeInMinutes = shiftStartingTime; timeInMinutes <= shiftEndingTime; timeInMinutes += 30) {
        var hours = Math.floor(timeInMinutes / 60);
        var minutes = timeInMinutes % 60;
        if (minutes < 10){
            minutes = '0' + minutes; 
        }

        var option = document.createElement("option");
        option.text = hours + ':' + minutes;
        selectID.add(option);
    }
};

//Execution starts here 
//function to populate both dropdowns 
const populateStartTime = (shift, startSelectID, endSelectID, checkbox, hoursField) => {
    if(checkbox.checked) {
        shift = shift.innerHTML;
        setShiftStartEndTimes(shift);
        removeOption(startSelectID);

        startSelectID.disabled = false;
        endSelectID.disabled = false;
        
        populateTimeInDropdown(shiftStartingTime, shiftEndingTime,startSelectID, endSelectID);
        removeOption(endSelectID);

        populateEndTime(startSelectID,endSelectID, hoursField);

        //Sets default value in shift end time dropdown
        lastOptionValue = endSelectID.options[endSelectID.options.length-1].value;
        endSelectID.value = lastOptionValue;

        calculateHours(startSelectID,endSelectID, hoursField);
    }
    else {  
        removeOption(startSelectID);
        startSelectID.disabled = true;
        removeOption(endSelectID);
        endSelectID.disabled = true;
        hoursField.value = '';
    }
    
};

//Split minute and seconds from time and save to array and return the same
const splitTime = (timeToSplit) => {

    if(timeToSplit == 0) {
        return 0;
    }
    else {
        const myArray = timeToSplit.split(':'); //spliting time value based on :
        var splittedTime = parseInt(myArray[0])*60 + parseInt(myArray[1]);

    return splittedTime;
    }
    

}

const calculateHours = (shiftStarts, shiftEnds, hoursField) => {

    hoursField.value = '';
    var startTime = shiftStarts.value;
    var endTime = shiftEnds.value;
    var newStartTime = splitTime(startTime);
    var newEndTime = splitTime(endTime);
    
   /*  var hours = Math.floor((newEndTime -newStartTime)/ 60);
        var minutes = (newEndTime -newStartTime) % 60;
        if (minutes < 10){
            minutes = '0' + minutes; 
        } */

        var hours = (newEndTime -newStartTime)/ 60;

        hoursField.value = hours;
}



