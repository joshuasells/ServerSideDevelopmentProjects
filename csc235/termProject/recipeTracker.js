// recipeTracker.js - javaScript scripting for the recipeTracker application.
// Written by: Joshua Sells
// Date: 12/30/2020

// set timeout to remove any php user messages after 5 seconds.
// This is will change the class of the messsages and css will handle the transition.
var msg = document.getElementsByClassName('msg');
if (msg.length > 0) {
  setTimeout(function() {
    for(var i = 0; i < msg.length; i++) {
      msg[i].classList.add("hide");
    } 
  
  }, 3000);
}