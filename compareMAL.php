<?php
/**
 * Created by PhpStorm.
 * User: Jesse
 * Date: 21-Sep-17
 * Time: 11:38
 */
$userNames = json_decode($_POST["names"]);
//echo nl2br("UserNames: \n");
//var_dump($userNames);
$lists = array();
//echo nl2br("Anzahl User: \n");
//var_dump(count($userNames));
for ($i = 0; $i < count($userNames); $i++) {
    $xml = file_get_contents('https://myanimelist.net/malappinfo.php?u=' . $userNames[$i] . '&status=all&type=anime');
    $xmlObj = simplexml_load_string($xml, "SimpleXMLElement", LIBXML_NOCDATA);
    $json = json_encode($xmlObj);
    $array = json_decode($json, true);
    $lists[$i] = $array;
}
//echo $lists;
//echo nl2br("Item: \n");
//var_dump($lists[0]["anime"][0]["series_title"]);
$duplicates = array();
$checkList = 1;
//for($j = 0; $j < count($lists);$j++){
for ($k = 0; $k < count($lists[0]["anime"]); $k++) {
    if ($lists[0]["anime"][$k]["series_title"] != NULL && $lists[0]["anime"][$k]["my_status"] == 6) {
        $currEntry = $lists[0]["anime"][$k];
        for ($t = 0; $t < count($lists[1]["anime"]); $t++) {
/*          echo $currEntry["series_title"];
            echo " t = " . $t . " Checklist = ". $checkList. " ";
            var_dump($lists[$checkList]["anime"][$t]["series_title"]);*/

            if ($currEntry["series_title"] == $lists[$checkList]["anime"][$t]["series_title"]) {
                $duplicates[count($duplicates)] = $currEntry;
            }
            if($checkList > count($lists)){
                $checkList = 1;
            }
        }
    }
}
//echo nl2br("Duplicates: \n");
//var_dump($duplicates);
//}

echo json_encode($duplicates);

//echo nl2br("Lists: \n");
//var_dump($lists);

// var_dump(file_get_contents('https://myanimelist.net/malappinfo.php?u=bobocato&status=all&type=anime'));
// $url = 'https://myanimelist.net/malappinfo.php?u=' . $userNames . '&status=all&type=anime';
