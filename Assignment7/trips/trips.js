"use strict";

$(document).ready( () => {
    $("#add_trip").click( () => {
        const trip = new Trip( 
          $("#destination").val(), $("#miles").val(), $("#gallons").val() );
        if (trip.isValid) {
            alltrips.push(trip);
            $("#trip_list").val(alltrips.toString());
            $("#destination").val("");
            $("#miles").val("");
            $("#gallons").val("");

            $("#destination").focus();
        } 
        else {
            alert("Please complete all fields.\nMiles and gallons " 
                + "must be numeric and greater than zero.");
            $("#destination").select();
        }
    });
    
    $("#destination").focus();
});