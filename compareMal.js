/**
 * Created by Jesse on 20-Sep-17.
 */
var $ = jQuery;

$(document).ready(function () {
    //Eventlistner to add extra users
    if (document.getElementById("addUser") !== null) {
        document.getElementById("addUser").addEventListener("click", function () {
            if (document.getElementsByClassName("userin").length < 4) {
                if (document.getElementsByClassName("userin").length <= 4) {
                    if (document.getElementsByClassName("userin").length % 2 === 0) {
                        document.getElementById("leftUserfield").innerHTML += '<label for="user3">Third User:</label><input type="text" name="3" class="form-control userin" class="userin" id="user3">'
                    } else {
                        document.getElementById("rightUserfield").innerHTML += '<label for="user4">Fourth User:</label><input type="text" name="4" class="form-control userin" class="userin" id="user4">'
                        document.getElementById("addUser").disabled = true;
                    }
                }
            }
        });
    }
    $(".clickable").click(function (event) {
        var url = "https://myanimelist.net/anime/" + event.target.id;
        console.log(event.target.id);
        console.log(url);
        window.open(url, "_blank");
    });
});