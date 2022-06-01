"use strict";

// get investment amount - loop until user enters a number
let investment = 0;
do {
    investment = parseFloat(
        prompt("Enter investment amount as xxxxx.xx", 10000));
}
while ( isNaN(investment) );

// get interest rate - loop until user enters a number
let rate = 0;
do {
    rate = parseFloat(prompt("Enter interest rate as xx.x", 7.5));
}
while ( isNaN(rate) );

// get number of years - loop until user enters a number
let years = 0;
do {
    years = parseInt(prompt("Enter number of years", 10));
}
while ( isNaN(years) );

// calulate future value with yearly interest
let futureValueWithYearlyInterest = investment;
for (let i = 1; i <= years; i++ ) {
    futureValueWithYearlyInterest += futureValueWithYearlyInterest * rate / 100;
}

// calulate future value with monthly interest
let futureValueWithMonthlyInterest = investment;
let months = years * 12;
for (let i = 1; i <= months; i++ ) {
    futureValueWithMonthlyInterest += futureValueWithMonthlyInterest * rate / 1200;
}

// display results for future value with yearly interest
document.write(`<h3>Future Value with Yearly Interest</h3>`)
document.write(`<p><label>Investment amount:</label> ${investment}</p>`);
document.write(`<p><label>Interest rate:</label> ${rate}</p>`);
document.write(`<p><label>Years:</label> ${years}</p>`);
document.write(`<p><label>Future Value:</label> ${futureValueWithYearlyInterest.toFixed(2)}</p>`);

// display results for future value with monthly interest
document.write(`<h3>Future Value with Monthly Interest</h3>`)
document.write(`<p><label>Investment amount:</label> ${investment}</p>`);
document.write(`<p><label>Interest rate:</label> ${rate}</p>`);
document.write(`<p><label>Years:</label> ${years}</p>`);
document.write(`<p><label>Future Value:</label> ${futureValueWithMonthlyInterest.toFixed(2)}</p>`);
