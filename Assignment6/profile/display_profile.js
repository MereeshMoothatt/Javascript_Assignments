"use strict";

$(document).ready( () => {
	// display data from session storage


		const email = sessionStorage.getItem("email");
        const phone = sessionStorage.getItem("phone");
        const zip = sessionStorage.getItem("zip");
        const dob = sessionStorage.getItem("dob");

		$("#email").text(email);	
		$("#phone").text(phone);
		$("#zip").text(zip);	
		$("#dob").text(dob);

	
	$("#back").click( () => {
		history.back();
	}); // end of click()
	
}); // end of ready()