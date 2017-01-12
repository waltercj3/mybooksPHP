//bookScripts.js

"use strict";

window.addEventListener("load", function() {
    var bookMessage, fetchButton, isbnInput, xhr, isbn;
    bookMessage = document.getElementById('bookMessage');
    fetchButton = document.getElementById('fetchButton');
    isbnInput = document.getElementById('isbnInput');
    xhr = new window.XMLHttpRequest();
    
    fetchButton.addEventListener("click", function() {
        var url;
        isbn = isbnInput.value;
        isbn = isbn.trim().toUpperCase();
        isbn = isbn.replace(/[^0-9,X]/g, "");
        if (isbn.length < 10) {
            while (isbn.length < 10) {
                isbn = "0" + isbn;
            }
        } 
        if (isbn.length != 10 && isbn.length != 13) {
            bookMessage.innerHTML = "<p>An ISBN should have 10 or 13 digits. Please try again.</p>";
        } else {
            url = "isbnResults.php?isbn=" + isbn;
            xhr.open("GET", url, true);
            xhr.send();
        }
        isbnInput.value = isbn;
    });
    
    xhr.addEventListener("load", function() {
        var response = JSON.parse(xhr.responseText);

        if(response.error) {
            bookMessage.innerHTML = response.error;
        } else {
            var titleInput, lastNameInput, firstNameInput, classInput, ratingInput, pubInput, myEdInput;
            titleInput = document.getElementById('titleInput');
            lastNameInput = document.getElementById('lastNameInput');
            firstNameInput = document.getElementById('firstNameInput');
            classInput = document.getElementById('classInput');
            ratingInput = document.getElementById('ratingInput');
            pubInput = document.getElementById('pubInput');
            myEdInput = document.getElementById('myEdInput');
            bookMessage.innerHTML = "<p>Results found.</p>";
            titleInput.value = response.data.title;
            lastNameInput.value = response.data.authorLast;
            firstNameInput.value = response.data.authorFirst;
            classInput.value = response.data.class_id;
            ratingInput.value = response.data.rating_id;
            pubInput.value = response.data.orig_pub_date;
            myEdInput.value = response.data.curr_ed_date;
        }
    });
});