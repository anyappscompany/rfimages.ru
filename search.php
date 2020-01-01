<?php
include_once("db.php");     //adlt=strict - строгий,         demote -moderate, OFF -откл http://www.bing.com/images/async?q=porn&format=htmlraw&first=0&ADLT=demote
include_once("settings.php");
include_once("functions.php");
$q = trim(urldecode ($_GET['q']));
$sq = trim(preg_replace('/ {2,}/',' ',preg_replace ("/[^\p{L}0-9]/iu"," ",mb_strtolower (urldecode ($_GET['q']), "UTF-8"))));

$result = mysqli_query($db, "SELECT * FROM cache WHERE kw='".mysqli_real_escape_string($db, $sq)."'") or die();
$num_rows = mysqli_num_rows($result);
$row=mysqli_fetch_assoc($result);

$cur_cache_time = strtotime($row['cachetime']);
$curtime = time();

if(($curtime-$cur_cache_time) > $cache_time || $num_rows == 0) {
    $html = get_web_page("http://www.bing.com/images/search?q=".urlencode($sq).'&ADLT=OFF&scope=images&nr=1&FORM=NOFORM');
    preg_match_all('/<a class="thumb" target="_blank" href="(?<image>.*?)"(.*?)<img height="[0-9]+" width="[0-9]+" src="(?<tumb>.*?)&amp;w=[0-9]+&amp;(.*?)href="(?<sourcepage>.*?)" h=(.*?)<div class="des">(?<alt>.*?)<\/div><div class="fileInfo">(?<w>.*?) x (?<h>.*?) (?<type>.*?) (?<size>.*?)</us', $html, $res);
    if(count($res['alt'])<=0) return;// закончить если фотки не спарсились
    $images = array();

    for($i=0; $i<count($res['alt']); $i++){
        $tmp = array();
        array_push($tmp, $res['alt'][$i]);
        array_push($tmp, $res['w'][$i]);
        array_push($tmp, $res['h'][$i]);
        array_push($tmp, $res['size'][$i]);
        array_push($tmp, $res['type'][$i]);
        array_push($tmp, $res['sourcepage'][$i]);
        array_push($tmp, $res['image'][$i]);
        array_push($tmp, $res['tumb'][$i]);

        array_push($images, $tmp);
        unset($tmp);
    }

    

    $result = mysqli_query($db, "INSERT INTO cache (kw, data, cachetime) VALUES ('".mysqli_real_escape_string($db, $sq)."','".mysqli_real_escape_string($db, json_encode($images))."', '".date("Y-m-d H:i:s")."') ON DUPLICATE KEY UPDATE cachetime='".date("Y-m-d H:i:s")."';");
    echo urlencode($sq);
}else{
    echo urlencode($row['kw']);
}

mysqli_close($db);
?>