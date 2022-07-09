"use strict";

$(document).ready(() => {
	const emailPattern = /\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}\b/; 
    const namePattern = /^[a-zA-Z]+ [a-zA-Z]+$/;
    const phonePattern = /^\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$/;

	$("#arrival_date").focus();

	$("#reservation_form").submit( event => {
		let isValid = true;

		//Arrival Date validation
		var arrivalDate = $("#arrival_date").val().trim();
		if (arrivalDate == "") {
			$("#arrival_date").next().text("Arrival date is required.");
			isValid = false;
		} 
		else {
            $("#arrival_date").next().text("");	
		}
        $("#arrival_date").val(arrivalDate);

        //Nights validation
        var nights = $("#nights").val().trim();
		if (nights == "") {
			$("#nights").next().text("Nights field is required.");
			isValid = false;
		}
        else if(isNaN(nights) || nights <= 0) {
            $("#nights").next().text("Nights field should be valid.");
			isValid = false;
        } 
		else {
            $("#nights").next().text("");	
		}
        $("#nights").val(nights);

        //Name validation
        var name = $("#name").val().trim();
		if (name == "") {
			$("#name").next().text("Name is required.");
			isValid = false;
		}
        else if(!namePattern.test(name)) {
            $("#name").next().text("Name field should be valid.");
			isValid = false;
        } 
		else {
            $("#name").next().text("");	
		}
        $("#name").val(name);

        // validate the email entry with a regular expression
        const emailPattern =
            /\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}\b/;
        const email = $("#email").val().trim();
        if (email == "") {
            $("#email").next().text("Email is required.");
            isValid = false;
        }
        else if (!emailPattern.test(email)) {
            $("#email").next().text("The email should be valid.");
            isValid = false;
        }
        else {
            $("#email").next().text("");
        }
        $("#email").val(email);

        //Phone Validation
        var phone = $("#phone").val().trim();
		if (phone == "") {
			$("#phone").next().text("phone field is required.");
			isValid = false;
		}
        else if(!phonePattern.test(phone)) {
            $("#phone").next().text("phone field should be valid.");
			isValid = false;
        } 
		else {
            $("#phone").next().text("");	
		}
        $("#phone").val(phone);

        
		if (isValid == false) {
            event.preventDefault();
        }

	});
		
}); // end ready