"use strict";

let formattedInvoiceDate;
let formattedDueDate;
let dueDate;

const calculateDiscount = (customer, subtotal) => {
    if (customer == "reg") {
        if (subtotal >= 100 && subtotal < 250) {
            return .1;
        } else if (subtotal >= 250 && subtotal < 500) {
            return .25;
        } else if (subtotal >= 500) {
            return .3;
        } else {
            return 0;
        }
    }
    else if (customer == "loyal") {
        return .3;
    }
    else if (customer == "honored") {
        if (subtotal < 500) {
            return .4;
        }
        else {
            return .5;
        }
    }
};

$(document).ready(() => {

    $("#calculate").click(() => {
        const customerType = $("#type").val();
        let subtotal = $("#subtotal").val();
        subtotal = parseFloat(subtotal);
        if (isNaN(subtotal) || subtotal <= 0) {
            alert("Subtotal must be a number greater than zero.");
            $("#clear").click();
            $("#subtotal").focus();
            return;
        }

        const discountPercent = calculateDiscount(customerType, subtotal);
        const discountAmount = subtotal * discountPercent;
        const invoiceTotal = subtotal - discountAmount;

        $("#subtotal").val(subtotal.toFixed(2));
        $("#percent").val((discountPercent * 100).toFixed(2));
        $("#discount").val(discountAmount.toFixed(2));
        $("#total").val(invoiceTotal.toFixed(2));

        // set focus on type drop-down when done  
        $("#type").focus();

        const invoiceDate = $("#invoice_date").val().trim();
        const dateParts = invoiceDate.split("/");
        const year = invoiceDate.substring(invoiceDate.length - 4);
        let enteredInvoiceDate = new Date(invoiceDate);

        if (invoiceDate == "") {
            // set invoice date and due date
            const today = new Date();
            setDates(today);

            //set focus on invoice date
            $("#invoice_date").focus();
            return;
        }
        else if (invoiceDate.length == 0 || dateParts.length != 3 || isNaN(year) || enteredInvoiceDate == "Invalid Date") {
            alert("Please enter a valid date in MM/DD/YYYY format.");
            //set focus on invoice date
            $("#invoice_date").focus();
            return;
        } else {
            //set invoice date and due date
            setDates(enteredInvoiceDate);
        }

    });

    $("#clear").click(() => {

        $("#type").val("reg");
        $("#subtotal").val("");
        $("#invoice_date").val("");
        $("#percent").val("");
        $("#discount").val("");
        $("#total").val("");
        $("#due_date").val("");

        // set focus on type drop-down when done
        $("#type").focus();
    })

    // set focus on type drop-down on initial load
    $("#type").focus();
});

function setDates(invoice_date) {
    formattedInvoiceDate = formatDate(invoice_date);
    $("#invoice_date").val(formattedInvoiceDate);

    //set due date
    dueDate = calculateDueDate(invoice_date);
    formattedDueDate = formatDate(dueDate);
    $("#due_date").val(formattedDueDate);
}

function calculateDueDate(due_date) {
    const calculatedDueDate = new Date(due_date);
    calculatedDueDate.setDate(calculatedDueDate.getDate() + 30);
    return calculatedDueDate;
}

function formatDate(date) {
    const yyyy = date.getFullYear();
    let mm = date.getMonth() + 1; // Months start at 0!
    let dd = date.getDate();
    let formattedDate = mm.toString().padStart(2, "0") + '/' + dd.toString().padStart(2, "0") + '/' + yyyy;
    return formattedDate;
}

