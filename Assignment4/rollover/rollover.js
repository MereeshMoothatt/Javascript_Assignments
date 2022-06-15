"use strict";
var timer;  

document.addEventListener("DOMContentLoaded", evt => {
    const images = document.querySelectorAll("#image_rollovers img");
    clearTimeout(timer);
    // process each img tag
    for (let image of images) {
        const oldURL = image.src;
        const newURL = image.id;
        
        clearTimeout(timer);
            
        // preload rollover images
        const newImageCache = new Image();
        newImageCache.src = newURL;
        const oldImageCache = new Image();
        oldImageCache.src = oldURL;


        function mouseOverImage() {
            clearTimeout(timer);
            image.src = newURL;
        }

        const startMouseOverImageTimer = () => {
            timer = setTimeout(mouseOverImage, 1000);
        };

        // set up event handlers for hovering an image
        image.addEventListener("mouseover", startMouseOverImageTimer); 
            
        const mouseOutImage = () => {
            clearTimeout(timer);
            image.src = oldURL;
        };

        const startMouseOutImageTimer = () => {
            timer = setTimeout(mouseOutImage, 2000);
        };
       
        // set up event handlers out of an image
        image.addEventListener("mouseout", startMouseOutImageTimer);

    }
    evt.preventDefault();
});

