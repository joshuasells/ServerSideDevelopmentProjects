// functions.js - javaScript functions for the recipeTracker application.
// Written by: Joshua Sells
// Date: 12/30/2020

// set global boolean to determine whether to execute addInventoryRow function
var rowAdded = false;
// set global boolean to determine whether to execute the addInputTags function
var rowEdited = false;
// set global boolean to determine whether to execute the doubleCheck function
var deleteButtonClicked = false;
// set global array to preserve any data from the inventory table.
var dataArray = [];

// --------------------------------FUNCTIONS------------------------------------

//----------------- showInventory() --------------------------------------------
// this function displays the inventory and hides the recipes by adding and removing classes from the elements.
function showInventory() {
  document.getElementById("navInventory").className = ("active");
  document.getElementById("navRecipes").classList.remove("active");
  document.getElementById("inventory").classList.remove("hidden");
  document.getElementById("recipes").className = ("hidden");
}

//--------------------showRecipes()--------------------------------------------
// This function displays the recipe content and hides the inventory content by adding and removing classes from the elements.
function showRecipes() {
  document.getElementById("navRecipes").className = ("active");
  document.getElementById("navInventory").classList.remove("active");
  document.getElementById("recipes").classList.remove("hidden");
  document.getElementById("inventory").className = ("hidden");
}

//-----------------addInventoryRow()------------------------------------
// This function adds a table row to the inventory table once the add item button is clicked.
function addInventoryRow() {
  if (!rowAdded) {
    // First check if a row is currently being added.
    if (rowEdited) {
      var cancelButton = document.getElementById("btnCancelEdit");
      cancelEdit(cancelButton);
    }
    var inventoryTable = document.getElementById("inventoryTable");
    // insert row
    var row = inventoryTable.insertRow(-1);
    // add id attribute to row
    row.setAttribute("id", "editRow");
    // insert cells
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    // populate cells
    cell1.innerHTML = "<input type='text' id='txtItem' placeholder='Item' name='txtItem' size='10' maxlength='20' onkeyup='checkTxtBox(this)' />";
    cell2.innerHTML = "<input type='text' id='txtDescription' placeholder='Description' name='txtDescription' size='30' maxlength='50' onkeyup='checkTxtBox(this)' />";
    cell3.innerHTML = "<input type='text' id='txtQuantity' placeholder='Quantity' name='txtQuantity' size='10' maxlength='20' onkeyup='checkTxtBox(this)' />";
    // add class and button to last cell
    cell4.setAttribute("class", "tableButton");
    cell4.innerHTML = "<button id='saveBtn' class='edit' type='button'>Save</button>" + 
      "<button class='delete' type='button' onclick='cancelAddRow()'>Cancel</button>";
    saveBtn = document.getElementById("saveBtn");
    saveBtn.setAttribute("onclick", "saveTableRow('add')");
    rowAdded = true;
  }
}

//----------------cancelAddRow---------------------------------------------
// This function will cancel out any row to be added to the database.
function cancelAddRow() {
  var inventoryTable = document.getElementById("inventoryTable");
  // delete the row that was added to be edited and saved.
  inventoryTable.deleteRow(-1);
  // set the boolean var, rowAdded, back to false.
  rowAdded = false;
}

//----------------------saveTableRow()---------------------------------------
function saveTableRow(method) {
  // boolean to make sure all text boxes are populated before submitting the form.
  var isEmpty = false;
  // get all the input elements in a node list.
  var row = document.querySelectorAll('#inventoryTable input');
  // get the form and assign it to the variable form.
  var form = document.getElementById("inventoryForm");

  // loop through them to check for empty text boxes.
  for (i = 0; i < row.length; i++) {
    if (row[i].value === "") {
      row[i].setAttribute("placeholder", "Enter text");
      row[i].setAttribute("style", "border-color: #DE541E;");
      // if a text box is found to be empty, then change boolean.
      isEmpty = true;
    }
  }

  // is the boolean is false, that means the text boxes are not empty.
  // This means we can finally submit the form for saving to a database.
  if (!isEmpty) {
    // if we are updating info rather then saving data then,
    // We need to add a hidden field with the original ingredient information.
    // Once we submit the form, PHP can query the database and get the ingredientID
    // Finally, we will be able to update the new information alongside the correct primary key.
    if (method == 'edit') {
      form.insertAdjacentHTML("beforeend", "<input type='hidden' name='hdnOriginalName' value='" + dataArray[0] + "' />");
      //form.insertAdjacentHTML("beforeend", "<input type='hidden' name='hdnOriginalDescription' value='" + dataArray[1] + "' />");
      //form.insertAdjacentHTML("beforeend", "<input type='hidden' name='hdnOriginalQuantity' value='" + dataArray[2] + "' />");
    }
    // Add a hidden input to let the server know which action to take.
    form.insertAdjacentHTML("beforeend", "<input type='hidden' name='hdnAction' value='" + method + "' />");
    form.submit();
  }
}

//------------------------checkTxtBox()------------------------------------
// This function will check to see if a text box is empty when the user presses a key.
function checkTxtBox(thisField) {
  if (thisField.value === "") {
    thisField.setAttribute("placeholder", "Enter text");
    thisField.setAttribute("style", "border-color: #DE541E;");
  }
  else {
    thisField.setAttribute("style", "border-color: #57C7A2;");
  }
}

//------------------------doubleCheck()----------------------------------
// This function double checks that the user wants to delete an item.
function doubleCheck(thisButton) {
  if (!deleteButtonClicked) {
    // If an edit row exists, we need to remove it.
    // If we don't do this, then the edit row post data will be submitted.
    // This is not what we want.
    var editRow = document.getElementById("editRow");
    if (editRow) {
      cancelAddRow();
    }
    // Additionally, if the user clicked to edit an existing item, we need to cancel that also.
    var editRowBtn = document.getElementById("btnCancelEdit");
    if (editRowBtn) {
      cancelEdit(editRowBtn);
    }
    // rule out the user hitting other buttons at this time.
    // Until they choose to delete for sure or to cancel.
    rowAdded = true;
    rowEdited = true; 

    thisButton.setAttribute("id", "activeDeleteBtn");
    var inventoryDivElement = document.getElementById("inventory");

    // Get the item name
    var itemName = document.getElementById("activeDeleteBtn").parentElement.parentElement.firstElementChild.innerHTML;


    inventoryDivElement.insertAdjacentHTML("beforebegin", 
    "<div id='doubleCheck' class='doubleCheck'><span>Are you sure you want to delete " + itemName + "?</span>" + 
    "<button class='edit' onclick='deleteItem()'>Yes</button><button class='delete' onclick='cancelDoubleCheck()'>No, Cancel</button></div>");
    deleteButtonClicked = true;
  }
}

//------------------------cancelDoubleCheck()-------------------------------
// This function executes when the user hits the delete button and then clicks cancel.
// It reverses the deletion process and then they can carry on.
function cancelDoubleCheck() {
  // Set booleans back to false so that the user can click buttons again.
  rowAdded = false;
  rowEdited = false;
  deleteButtonClicked = false;
  // remove id attribute from the delete button clicked.
  document.getElementById("activeDeleteBtn").removeAttribute("id");
  // remove message
  removeFadeOut(document.getElementById("doubleCheck"), 500);
}

//-----------------------deleteItem()----------------------------------
// This function will work to submit a form for deleting an item from the database
function deleteItem() {
  // Get the active row data
  var activeDeleteBtn = document.getElementById("activeDeleteBtn");
  var activeRow = activeDeleteBtn.parentElement.parentElement;
  var cell1 = activeRow.firstElementChild;
  var cell2 = cell1.nextElementSibling;
  var cell3 = cell2.nextElementSibling;

  var item = cell1.innerHTML;
  var description = cell2.innerHTML;
  var quantity = cell3.innerHTML;

  // Add hidden fields to be sent to the server
  var form = document.getElementById("inventoryForm");
  form.insertAdjacentHTML("beforeend", "<input type='hidden' id='hdnItem' name='hdnItem' value='" + item + "'/>")
  form.insertAdjacentHTML("beforeend", "<input type='hidden' id='hdnDescription' name='hdnDescription' value='" + description + "'/>")
  form.insertAdjacentHTML("beforeend", "<input type='hidden' id='hdnQuantity' name='hdnQuantity' value='" + quantity + "'/>")

  // Add a hidden input to let the server know which action to take.
  form.insertAdjacentHTML("beforeend", "<input type='hidden' name='hdnAction' value='delete' />")

  // Now we can submit the form for deletion.
  form.submit();

}

//--------------addInputTags()--------------------------------------------
// This function adds input tags around the active table row.
// It returns an array of the original values of the table row. This is for if the user clicks the cancel button later on.
function addInputTags(thisButton) {
  if (!rowEdited) {
    // If the add item button was clicked and then the user also clicked the edit button,
    // we should get rid of the row at the bottem of the table.
    var editRow = document.getElementById("editRow");
    if (editRow) {
      cancelAddRow();
    }
    // Get the active row
    var activeRow = thisButton.parentElement.parentElement;
    var cell1 = activeRow.firstElementChild;
    var cell2 = cell1.nextElementSibling;
    var cell3 = cell2.nextElementSibling;
    var saveButton = thisButton;
    var cancelButton = thisButton.nextElementSibling;

    // Set id attribute to cancel button. This is for Javascript to find it later.
    cancelButton.setAttribute("id", "btnCancelEdit");
    // Change onclick attribute of buttons
    saveButton.setAttribute("onclick", "saveTableRow('edit')");
    cancelButton.setAttribute("onclick", "cancelEdit(this)");
    // change html in buttons
    saveButton.innerHTML = "Save";
    cancelButton.innerHTML = "Cancel";

    var item = cell1.innerHTML;
    var description = cell2.innerHTML;
    var quantity = cell3.innerHTML;

    // This is to preserve the original information.
    // Once we change it, the user could enter in anything and if they want to cancal,
    // We need a way to return the original data.
    dataArray = [item, description, quantity];

    // populate cells with input tags.
    // Retain the old value
    cell1.innerHTML = "<input class='hide' type='text' id='txtItem' placeholder='Item' name='txtItem' size='10' maxlength='20' onkeyup='checkTxtBox(this)' value='" + item + "'/>";
    cell2.innerHTML = "<input class='hide' type='text' id='txtDescription' placeholder='Description' name='txtDescription' size='30' maxlength='50' onkeyup='checkTxtBox(this)' value='" + description + "'/>";
    cell3.innerHTML = "<input class='hide' type='text' id='txtQuantity' placeholder='Quantity' name='txtQuantity' size='10' maxlength='20' onkeyup='checkTxtBox(this)' value='" + quantity + "'/>";
    // Set a boolean variable to true to indicate that this button has already been pushed
    rowEdited = true;
  }
}

//---------------------cancelEdit()----------------------------------------
// This function cancels out the edit button. It puts the table row back to the way it was.
function cancelEdit(thisButton) {
  // Get the active row
  var activeRow = thisButton.parentElement.parentElement;
  var cell1 = activeRow.firstElementChild;
  var cell2 = cell1.nextElementSibling;
  var cell3 = cell2.nextElementSibling;

  // Repopulate the table cells with the original data.
  cell1.innerHTML = dataArray[0];
  cell2.innerHTML = dataArray[1];
  cell3.innerHTML = dataArray[2];

  // Remove ID attribute from cancel button. It will be turned back into an edit button.
  thisButton.removeAttribute("id");

  // Get the buttons
  var editButton = thisButton.previousElementSibling;
  var deleteButton = thisButton;
  // Change onclick attribute of buttons
  editButton.setAttribute("onclick", "addInputTags(this)");
  deleteButton.setAttribute("onclick", "doubleCheck(this)");
  // change html in buttons
  editButton.innerHTML = "Edit";
  deleteButton.innerHTML = "Delete";

  // Set boolean variable to false to indicate that the edit button can be pushed again.
  rowEdited = false;
}

//------------------------removeFadeOut()-------------------
// This function takes in an element and speed argument.
// It fades out the element at the speed and then removes it from the DOM
function removeFadeOut( element, speed ) {
  var seconds = speed/1000;
  element.style.transition = "opacity "+seconds+"s ease";

  element.style.opacity = 0;
  setTimeout(function() {
      element.parentNode.removeChild(element);
  }, speed);
}