document.addEventListener("DOMContentLoaded", function () {
    if (document.querySelector("form[name='query_people']")) {
        ajaxFormSubmit("form[name='query_people']", "people_table.php");
    }
    if (document.querySelector("form[name='query_vehicles']")) {
        ajaxFormSubmit("form[name='query_vehicles']", "vehicles_table.php");
    }

    // more form submissions here

    if (document.getElementById("myInput")) {
        autocomplete(document.getElementById("myInput"));
    }

    if (document.getElementById("mySearch")) {
        document.getElementById("mySearch").addEventListener("keyup", function () {
            searchMenu();
        });
    }

    if (document.getElementById("newmyInput")) {
        document.getElementById("newmyInput").addEventListener("keyup", function () {
            showMatches(document.getElementById("newmyInput").value);
        });
    }
    // check if side navigation bar is open or closed
    checkNavState();

});

function ajaxFormSubmit(formSelector, targetUrl) {
    document.querySelector(formSelector).addEventListener("submit", function (event) {
        event.preventDefault();    // stop the form from submitting

        var formData = new FormData(this);
        var xhr = new XMLHttpRequest();
        xhr.open("POST", targetUrl, true);

        xhr.onload = function () {
            if (this.status == 200) {
                document.querySelector(".container").innerHTML = this.responseText;
            }
        };

        xhr.send(formData);
    });
}


function validateForm() {
    var x = document.forms["myForm"]["fname"].value; // see https://www.w3schools.com/js/js_htmldom_document.asp
    if (x == "") {
        alert("Name must be filled out");
        return false;
    }
}


// hide or show side navigation bar
function toggleNav() {
    var sideNavs = document.getElementsByClassName("sidenav");
    var mainContent = document.getElementsByTagName("main");

    for (var i = 0; i < sideNavs.length; i++) {
        if (sideNavs[i].style.width == "15%") {
            sideNavs[i].style.width = "0";
            sessionStorage.setItem("sideNavState", "closed");

        } else {
            sideNavs[i].style.width = "15%";
            sessionStorage.setItem("sideNavState", "open");
        }
    }

    for (var i = 0; i < mainContent.length; i++) {
        if (mainContent[i].style.marginLeft == "20%") {
            mainContent[i].style.marginLeft = "20%";
        } else {
            mainContent[i].style.marginLeft = "20%";
        }
    }
}

function closeNav() {
    var sideNavs = document.getElementsByClassName("sidenav");
    var mainContent = document.getElementsByTagName("main");

    for (var i = 0; i < sideNavs.length; i++) {
        sideNavs[i].style.width = "0";
        sessionStorage.setItem("sideNavState", "closed");
    }
    for (var i = 0; i < mainContent.length; i++) {
        mainContent[i].style.marginLeft = "20%";
    }
}

function checkNavState() {
    var sideNavState = sessionStorage.getItem("sideNavState");

    var sideNavs = document.getElementsByClassName("sidenav");
    var mainContent = document.getElementsByTagName("main");

    if (sideNavState == "closed") {
        for (var i = 0; i < sideNavs.length; i++) {
            sideNavs[i].style.width = "0";
        }
        for (var i = 0; i < mainContent.length; i++) {
            mainContent[i].style.marginLeft = "20%";
        }
    }
    else {
        for (var i = 0; i < sideNavs.length; i++) {
            sideNavs[i].style.width = "15%";
        }
        for (var i = 0; i < mainContent.length; i++) {
            mainContent[i].style.marginLeft = "20%";
        }
    }
}




// search menu for sidenav bar
function searchMenu() {
    var input, filter, ul, li, a, i, j, currentText, found;
    input = document.getElementById("mySearch");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myMenu");
    li = ul.getElementsByTagName("li");

    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        currentText = a.innerHTML.toUpperCase();
        found = true;

        // check if all characters in filter are found in currentText
        for (j = 0; j < filter.length; j++) {
            if (filter[j] === " ") continue; // skip spaces

            var charIndex = currentText.indexOf(filter[j]);
            if (charIndex === -1) {
                found = false;
                break;
            } else {
                // only remove the first occurrence of the character
                currentText = currentText.substring(0, charIndex) + currentText.substring(charIndex + 1);
            }
        }

        // if all characters in filter are found in currentText, show the li item
        if (found) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}

function searchText(filter, content) {

    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        currentText = a.innerHTML.toUpperCase();
        found = true;

        // check if all characters in filter are found in currentText
        for (j = 0; j < filter.length; j++) {
            if (filter[j] === " ") continue; // skip spaces

            var charIndex = currentText.indexOf(filter[j]);
            if (charIndex === -1) {
                found = false;
                break;
            } else {
                // only remove the first occurrence of the character
                currentText = currentText.substring(0, charIndex) + currentText.substring(charIndex + 1);
            }
        }

        // if all characters in filter are found in currentText, show the li item
        if (found) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}


// autocomplete for owner in add-vehicle form
function showMatches(inputText) {
    if (inputText.length == 0) {
        document.getElementById("ownerMatches").innerHTML = "";
        return;
    }
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            document.getElementById("ownerMatches").innerHTML = this.responseText;
        }
    };
    xhr.open("GET", "inc/get_people.php?q=" + inputText, true);
    xhr.send();
}

// close the autocomplete dropdown when user clicks outside of it
// document.addEventListener("click", function (event) {
//     document.getElementById("ownerMatches").innerHTML = "";
// });

function selectOwner(name) {
    document.getElementById("owner").value = name;
    document.getElementById("ownerMatches").innerHTML = "";
}


function openNewOwnerForm() {
    document.getElementById("newOwnerModal").style.display = "block";
}

function closeNewOwnerForm() {
    document.getElementById("newOwnerModal").style.display = "none";
}






function autocomplete(inpElement) {
    // the autocomplete function takes one argument the text field element 
    var currentFocus;

    // execute a function when someone writes in the text field
    inpElement.addEventListener("input", function (e) {
        var a, b, i, val = this.value;
        // close any already open lists of autocompleted values
        closeAllLists();

        if (!val) { return false; }
        currentFocus = -1;

        // create a DIV element that will contain the items (values)
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        // append the DIV element as a child of the autocomplete container
        this.parentNode.appendChild(a);

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var people;
                var val = inpElement.value.toUpperCase();

                // found at least a match
                if (!this.responseText.includes("<p>")) {
                    people = JSON.parse(this.responseText);
                } else {
                    people = [];
                }

                if (people.length == 0) {
                    b = document.createElement("P");
                    b.innerHTML = "<p>No matches found.<br>Please add this person.</p><button onclick='openNewOwnerForm()'>Add New Person</button>";
                    a.appendChild(b);
                }

                for (i = 0; i < people.length; i++) {
                    
                    // check if the item starts with the same letters as the text field value
                    if (people[i].People_name.substr(0, val.length).toUpperCase() == val.toUpperCase()) {

                        // create a DIV element for each matching element
                        b = document.createElement("DIV");
                        // make the matching letters bold
                        b.innerHTML = "<strong>" + people[i].People_name.substr(0, val.length) + "</strong>";
                        b.innerHTML += people[i].People_name.substr(val.length) + " - " + people[i].People_licence;

                        // insert a input field that will hold the current array item's value
                        b.innerHTML += "<input type='hidden' value='" + people[i].People_name + people[i].People_licence + "'>";

                        // execute a function when someone clicks on the item value (DIV element)
                        b.addEventListener("click", function (e) {
                            // insert the value for the autocomplete text field
                            inpElement.value = this.getElementsByTagName("input")[0].value;
                            // close the list of autocompleted values (or any other open lists of autocompleted values)
                            closeAllLists();
                        });
                        a.appendChild(b);
                    }
                }

            }
        };
        // xhr.open("GET", "inc/get_people.php?q=" + inpElement.value, true);
        xhr.open("GET", "inc/get_people.php?q=" + encodeURIComponent(inpElement.value), true);
        document.getElementById("myInput")
        xhr.send();
    });

    // execute a function presses a key on the keyboard:
    inpElement.addEventListener("keydown", function (e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {
            // If the arrow DOWN key is pressed, increase the currentFocus variable
            currentFocus++;
            // and make the current item more visible
            addActive(x);
        } else if (e.keyCode == 38) { //up
            // If the arrow UP key is pressed, decrease the currentFocus variable
            currentFocus--;
            // and make the current item more visible
            addActive(x);
        } else if (e.keyCode == 13) {
            // If the ENTER key is pressed, prevent the form from being submitted
            e.preventDefault();
            if (currentFocus > -1) {
                // simulate a click on the "active" item
                if (x) x[currentFocus].click();
            }
        }
    });

    function addActive(x) {
        /*a function to classify an item as "active":*/
        if (!x) return false;
        /*start by removing the "active" class on all items:*/
        removeActive(x);
        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = (x.length - 1);
        /*add class "autocomplete-active":*/
        x[currentFocus].classList.add("autocomplete-active");
    }
    function removeActive(x) {
        /*a function to remove the "active" class from all autocomplete items:*/
        for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
        }
    }
    function closeAllLists(elmnt) {
        /*close all autocomplete lists in the document,
        except the one passed as an argument:*/
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inpElement) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }
    /*execute a function when someone clicks in the document:*/
    document.addEventListener("click", function (e) {
        closeAllLists(e.target);
    });
}