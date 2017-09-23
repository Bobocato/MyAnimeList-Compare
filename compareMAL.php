<?php
/**
 * Created by PhpStorm.
 * User: Jesse
 * Date: 21-Sep-17
 * Time: 11:38
 */

function getList($userNames) {
    for ($i = 0; $i < count($userNames); $i++) {
        $xml = file_get_contents('https://myanimelist.net/malappinfo.php?u=' . $userNames[$i + 1] . '&status=all&type=anime');
        $xmlObj = simplexml_load_string($xml, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xmlObj);
        $array = json_decode($json, true);
        $lists[$i] = $array;
    }
    return $lists;
}

function compareLists($lists, $listCounter, $checkCounter) {
    $duplicates = array();
    for ($k = 0; $k < count($lists[$listCounter]["anime"]); $k++) {
        if ($lists[$listCounter]["anime"][$k]["series_title"] != NULL && $lists[$listCounter]["anime"][$k]["my_status"] == 6) {
            $currEntry = $lists[$listCounter]["anime"][$k];
            for ($t = 0; $t < count($lists[$checkCounter]["anime"]); $t++) {
                if ($currEntry["series_title"] == $lists[$checkCounter]["anime"][$t]["series_title"] && $lists[$checkCounter]["anime"][$t]["my_status"] == 6) {
                    $duplicates[count($duplicates)] = $currEntry;
                }
            }
        }
    }
    return $duplicates;
}

function compareDuplicates($duplicates1, $duplicates2) {
    $compared = array();
    for ($i = 0; $i < count($duplicates1); $i++) {
        $currEntry = $duplicates1[$i];
        for ($j = 0; $j < count($duplicates2); $j++) {
            if ($currEntry["series_title"] == $duplicates2[$j]["series_title"]) {
                $compared[count($compared)] = $currEntry;
            }
        }
    }
    return $compared;
}

function compareByName($a, $b){
    return strcmp($a["series_title"], $b["series_title"]);
}

function headerPage() {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Compare your MAL</title>
        <!-- jQuery and Bootstrap -->
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!-- meta for mobile devices -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- My js and css -->
        <script src="compareMal.js"></script>
        <link rel="stylesheet" href="compareMal.css">
    </head>
    <?php
}

function errorPage() {
    ?>
    <body>
    <div class="page-header center">
        <a href="index.html"><h1>MyAnimeList Compare</h1></a>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <h2 class="center">Something went wrong! FeelsBadMan</h2>
            </div>
            <div class="col-sm-1"></div>
        </div>
    </div>
    </body>
    </html>
    <?php
}

function resultPage($results) {
    ?>
    <body>
    <div class="page-header center">
        <a href="index.html"><h1>MyAnimeList Compare</h1></a>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <div id="result">
                    <table class="table table-hover" id="resultTable">
                        <thead>
                        <tr>
                            <th>Nr.</th>
                            <th>Picture</th>
                            <th>Name</th>
                            <th>Episodes</th>
                        </tr>
                        </thead>
                        <tbody id="tableBody"></tbody>
                        <?php
                        for ($i = 0; $i < count($results); $i++) {
                            ?>
                            <tr class="clickable" id="<?php echo $results[$i]["series_animedb_id"] ?>">
                                <td id="<?php echo $results[$i]["series_animedb_id"] ?>">
                                    <div id="<?php echo $results[$i]["series_animedb_id"] ?>"> <?php echo($i + 1) ?> </div>
                                </td>
                                <td id="<?php echo $results[$i]["series_animedb_id"] ?>">
                                    <img id="<?php echo $results[$i]["series_animedb_id"] ?>"
                                         src="<?php echo $results[$i]["series_image"] ?>"/>
                                </td>
                                <td id="<?php echo $results[$i]["series_animedb_id"] ?>">
                                    <div id="<?php echo $results[$i]["series_animedb_id"] ?>"> <?php echo $results[$i]["series_title"] ?></div>
                                </td>
                                <td id="<?php echo $results[$i]["series_animedb_id"] ?>">
                                    <div id="<?php echo $results[$i]["series_animedb_id"] ?>"> <?php echo $results[$i]["series_episodes"] ?> </div>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
            <div class="col-sm-1"></div>
        </div>
    </div>
    </body>
    </html>
    <?php
}

if($_GET[1] == ""){
    $userNames = array();
} else {
    $userNames = $_GET;
}

switch (count($userNames)) {
    case 0:
        headerPage();
        errorPage();
        break;
    case 1:
        headerPage();
        errorPage();
        break;
    case 2:
        $lists = array();
        $lists = getList($userNames);
        $duplicates = compareLists($lists, 0, 1);
        usort($duplicates,"compareByName");
        headerPage();
        resultPage($duplicates);
        //var_dump($duplicates);
        break;
    case 3:
        $lists = array();
        $lists = getList($userNames);
        $duplicates1 = compareLists($lists, 0, 1);
        $duplicates2 = compareLists($lists, 0, 2);
        $compared = compareDuplicates($duplicates1, $duplicates2);
        usort($compared,"compareByName");
        headerPage();
        resultPage($compared);
        //var_dump($compared);
        break;
    case 4:
        $lists = array();
        $lists = getList($userNames);
        $duplicates1 = compareLists($lists, 0, 1);
        $duplicates2 = compareLists($lists, 2, 3);
        $compared = compareDuplicates($duplicates1, $duplicates2);
        usort($compared,"compareByName");
        headerPage();
        resultPage($compared);
        //var_dump($compared);
        break;
}