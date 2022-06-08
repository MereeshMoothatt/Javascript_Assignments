"use strict"
const $ = selector => document.querySelector(selector);
var itemName = [];
var itemPrice = [];
let itemCount = 0;

//This method is used to clear order
const clearItems = () => {
    itemName = [];
    itemPrice = [];
    itemCount = 0;
    $("#orders_display").value = "";
    $("#total").textContent = "";
}
//
document.addEventListener("DOMContentLoaded", () => {
    const images = document.querySelectorAll("#image_rollover img");

   
    for (let image of images) {

        // setting oldURL and new URL from the current image of all images
        // on mouse over newURL set as image source and mouse out oldURL set as imagesource
        const oldURL = image.src;
        const newURL = image.id;

         //This is to preload images
         const imageCache = new Image();
         imageCache.src = newURL;

        //the mouse over image swaps image with the image id attribute of current image
        image.addEventListener("mouseover", () => {
            image.src = newURL;
        });

        //the mouse out image swaps image with the image src attribute of current image (sets default image back)
        image.addEventListener("mouseout", () => {
            image.src = oldURL;
        });

        //the click on image add the clicked image item.
        image.addEventListener("click", addItems(oldURL));
    }

    // The click on clear order button will clear items
    $("#clear_order").addEventListener("click", clearItems);
});

//This method add the clicked image items 
function addItems(oldURL) {
    return () => {
        if (oldURL.includes("espresso")) {
            itemName[itemCount] = "Espresso";
            itemPrice[itemCount] = 1.95;
            itemCount++;
        } else if (oldURL.includes("latte")) {
            itemName[itemCount] = "Latte";
            itemPrice[itemCount] = 2.95;
            itemCount++;
        } else if (oldURL.includes("cappuccino")) {
            itemName[itemCount] = "Cappuccino";
            itemPrice[itemCount] = 3.45;
            itemCount++;
        } else if (oldURL.includes("coffee")) {
            itemName[itemCount] = "Coffee";
            itemPrice[itemCount] = 1.75;
            itemCount++;
        } else if (oldURL.includes("biscotti")) {
            itemName[itemCount] = "Biscotti";
            itemPrice[itemCount] = 1.95;
            itemCount++;
        } else if (oldURL.includes("scone")) {
            itemName[itemCount] = "Scone";
            itemPrice[itemCount] = 2.95;
            itemCount++;
        } else {
            itemCount[itemCount] = "Sorry! some error occured.";
            counter++;
        }
        let order_display = "";
        let total_display = 0;
        for (let counter = 0; counter < itemName.length; counter++) {
            order_display += "$" + itemPrice[counter] + " - " + itemName[counter] + "\n";
            total_display += itemPrice[counter];
        }
        $("#orders_display").value = order_display;
        $("#total").textContent = total_display.toFixed(2);
    };
}

