/**
 * Created by Jesse on 20-Sep-17.
 */
var $ = jQuery;
console.log("LuuL");
function showShows(showList) {
    fragment = document.createDocumentFragment();
    for (var i = 0; i < showList.length; i++){
        $('<tr class="clickable" id="' + showList[i]["series_animedb_id"] + '"></trclass>').append(
            $('<td id="' + showList[i]["series_animedb_id"] + '"></td>').append(
                $('<div id="' + showList[i]["series_animedb_id"] + '">'+ (i + 1) +'.</div>')
            ),
            $('<td id="' + showList[i]["series_animedb_id"] + '"></td>').append(
                $('<image id="' + showList[i]["series_animedb_id"] + '" src="'+ showList[i]["series_image"] +'"/>')
            ),
            $('<td id="' + showList[i]["series_animedb_id"] +'"></td>').append(
                $('<div id="' + showList[i]["series_animedb_id"] + '">'+ showList[i]["series_title"] +'</div>')
            ),
            $('<td id="' + showList[i]["series_animedb_id"] + '"></td>').append(
                $('<div id="' + showList[i]["series_animedb_id"] + '">'+ showList[i]["series_episodes"] +'</div>')
            )
        ).appendTo(fragment);
    }
    $("#tableBody").append(fragment);


    $(".clickable").click(function (event) {
        var url = "https://myanimelist.net/anime/" + event.target.id;
        console.log(event.target.id);
        console.log(url);
        window.open(url, "_blank");
    });

}

function changeView() {
    $("#form").remove();
    document.getElementById("result").style.display = "block";
}

$(document).ready(function () {
    //Eventlistner to add extra users
    document.getElementById("addUser").addEventListener("click", function () {
        if (document.getElementsByClassName("userin").length < 4) {
            if (document.getElementsByClassName("userin").length <= 4) {
                if (document.getElementsByClassName("userin").length % 2 === 0) {
                    document.getElementById("leftUserfield").innerHTML += '<label for="user3">Third User:</label><input type="text" class="form-control userin" class="userin" id="user3">'
                } else {
                    document.getElementById("rightUserfield").innerHTML += '<label for="user4">Fourth User:</label><input type="text" class="form-control userin" class="userin" id="user4">'
                    document.getElementById("addUser").disabled = true;
                }
            }
        }
    });
    //Eventlistner to start the comparison
    document.getElementById("compare").addEventListener("click", function () {
        var userName = [];
        for (var i = 0; i < document.getElementsByClassName("userin").length; i++) {
            userName[i] = document.getElementsByClassName("userin")[i].value;
        }
        var json = JSON.stringify(userName);
        console.log(json);

        $.ajax({
            type: "POST",
            url: "compareMAL.php",
            dataType: "json",
            data: {"names": json},
            success: function (response) {
                console.log(response);
                changeView();
                showShows(response);
            }
        })
        $("#compare").disabled = true;
    })

});