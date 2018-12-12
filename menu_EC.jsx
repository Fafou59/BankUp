function openPage(pageName, elmnt, color) {
    // Hide all elements with class="tabcontent" by default */
    var i, item_EC, lienEC;
    item_EC = document.getElementsByClassName("item_EC");
    for (i = 0; i < item_EC.length; i++) {
      item_EC[i].style.display = "none";
    }
  
    // Remove the background color of all tablinks/buttons
    lienEC = document.getElementsByClassName("lienEC");
    for (i = 0; i < lienEC.length; i++) {
      lienEC[i].style.backgroundColor = "";
    }
  
    // Show the specific tab content
    document.getElementById(pageName).style.display = "block";
  
    // Add the specific color to the button used to open the tab content
    elmnt.style.backgroundColor = color;
  }
  
  // Get the element with id="defaultOpen" and click on it
  document.getElementById("defaultOpen").click();