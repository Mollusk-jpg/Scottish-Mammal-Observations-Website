// Thanks to SnowMonkey! (https://stackoverflow.com/users/1964418/snowmonkey)
// Code taken from: https://stackoverflow.com/questions/47798971/several-modal-images-on-page

// Get the modal
var modal = document.getElementById("myModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var images = document.getElementsByClassName('myImages');
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
// Go through all of the images with our custom class
for (var i = 0; i < images.length; i++) {
    var img = images[i];
  // and attach our click listener for this image.
    img.onclick = function(evt) {
    modal.style.display = "block";
    modalImg.src = this.src;
    captionText.innerHTML = this.alt;
    }
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
    modal.style.display = "none";
}

// Taken from https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_sort_table_desc

function sortTable(n) {
var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
table = document.getElementById("myTable");
switching = true;
//Set the sorting direction to ascending:
dir = "asc"; 
/*Make a loop that will continue until
no switching has been done:*/
while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
        //start by saying there should be no switching:
        shouldSwitch = false;
        /*Get the two elements you want to compare,
        one from current row and one from the next:*/
        x = rows[i].getElementsByTagName("TD")[n];
        y = rows[i + 1].getElementsByTagName("TD")[n];
        /*check if the two rows should switch place,
        based on the direction, asc or desc:*/
        if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
            //if so, mark as a switch and break the loop:
            shouldSwitch= true;
            break;
        }
        } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
            //if so, mark as a switch and break the loop:
            shouldSwitch = true;
            break;
            }
        }
    }
    if (shouldSwitch) {
        /*If a switch has been marked, make the switch
        and mark that a switch has been done:*/
        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
        switching = true;
      //Each time a switch is done, increase this count by 1:
        switchcount ++;      
    } else {
    /*If no switching has been done AND the direction is "asc",
    set the direction to "desc" and run the while loop again.*/
    if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
        }
    }
}
}

//  Taken from https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_sort_table_number
function sortTableNumber(n) {
var table, rows, switching, i, x, y, shouldSwitch;
table = document.getElementById("myTable");
switching = true;
/*Make a loop that will continue until
no switching has been done:*/
while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
        //start by saying there should be no switching:
        shouldSwitch = false;
        /*Get the two elements you want to compare,
        one from current row and one from the next:*/
        x = rows[i].getElementsByTagName("TD")[n];
        y = rows[i + 1].getElementsByTagName("TD")[n];
        //check if the two rows should switch place:
        if (Number(x.innerHTML) > Number(y.innerHTML)) {
            //if so, mark as a switch and break the loop:
            shouldSwitch = true;
            break;
        }
    }
    if (shouldSwitch) {
        /*If a switch has been marked, make the switch
        and mark that a switch has been done:*/
        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
        switching = true;
        }
    }
}


function mySearchFunctionNames() {
  // Declare variables
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInputName");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
            }
        }
    }
}

function mySearchFunctionCStatus() {
  // Declare variables
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInputCStatus");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[2];
        if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
            }
        }
    }
}

function mySearchFunctionDiet() {
  // Declare variables
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInputDiet");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[3];
        if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
            }
        }
    }
}

function mySearchFunctionHabitat() {
  // Declare variables
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInputHabitat");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[5];
        if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
            }
        }
    }
}