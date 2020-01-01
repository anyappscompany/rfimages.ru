<?php
$blocked_url = array();
$blocked_url[] = "/naked%20young%20boys";
foreach($blocked_url as $burl){
    if($_SERVER['REQUEST_URI'] === $burl){ //echo "123";
        header("HTTP/1.1 301 Moved Permanently");
        header( 'Location: /', true, 301 );
        exit;
    }
}
//echo include_once("template/template.html");
include_once("settings.php");
include_once("db.php");
include_once("functions.php");

$result = mysqli_query($db, "SELECT id FROM cache");
$total_records = mysqli_num_rows($result);

$home = true;
$page_template = file_get_contents("template/template.html");

$page_template = str_replace("[UNIQUE]", md5(uniqid(rand(),1)), $page_template);
$page_template = str_replace("[COPYRIGHT]", $copyright_text, $page_template);
$page_template = str_replace("[LANG]", $lang, $page_template);
$page_template = str_replace("[SITE-TITLE]", $site_title, $page_template);
// top меню
foreach($top_menu_elements as $tm){
    $top_menu .= '<li><a class="top-menu-element" href="http://'.$_SERVER['SERVER_NAME'].'/'.mb_strtolower ($tm, "UTF-8").'">'.mb_strtolower ($tm, "UTF-8").'</a></li>';
}
$page_template = str_replace("[TOP-MENU-ELEMENTS]", $top_menu, $page_template);
// случайные записи
$top_random_records = array();
$bottom_random_records = array();

$random_items_id = array();
$random_items_query = "";
while(true){
    $rnd = rand(1, intval($total_records));
    array_push($random_items_id, $rnd);
    $random_items_id = array_unique($random_items_id);
    if(count($random_items_id)==14 || $total_records<14) break;
}
$random_items_id = array_values($random_items_id);

for($i=0; $i<count($random_items_id); $i++){
    $random_items_query .= "select id, kw from cache where id=".$random_items_id[$i];
    if($i==(count($random_items_id)-1)) break;
    $random_items_query .= " union ";
}
$result = mysqli_query($db, $random_items_query);

$count = 1;
while ($row = mysqli_fetch_assoc($result)) {

    switch($count){
        case 1:{
            $top_random_records[] = '<a class="w3-btn hidden-xs" href="http://'.$_SERVER['SERVER_NAME'].'/'.mb_strtolower ($row['kw'], "UTF-8").'">'.mb_strtolower ($row['kw'], "UTF-8").'</a>';
            break;
        }
        case 2:{
            $top_random_records[] = '<a class="w3-btn hidden-xs" href="http://'.$_SERVER['SERVER_NAME'].'/'.mb_strtolower ($row['kw'], "UTF-8").'">'.mb_strtolower ($row['kw'], "UTF-8").'</a>';
            break;
        }
        case 3:{
            $top_random_records[] = '<a class="w3-btn hidden-xs" href="http://'.$_SERVER['SERVER_NAME'].'/'.mb_strtolower ($row['kw'], "UTF-8").'">'.mb_strtolower ($row['kw'], "UTF-8").'</a>';
            break;
        }
        case 4:{
            $top_random_records[] = '<a class="w3-btn hidden-xs" href="http://'.$_SERVER['SERVER_NAME'].'/'.mb_strtolower ($row['kw'], "UTF-8").'">'.mb_strtolower ($row['kw'], "UTF-8").'</a>';
            break;
        }
        case 5:{
            $top_random_records[] = '<a class="w3-btn hidden-sm hidden-xs" href="http://'.$_SERVER['SERVER_NAME'].'/'.mb_strtolower ($row['kw'], "UTF-8").'">'.mb_strtolower ($row['kw'], "UTF-8").'</a>';
            break;
        }
        case 6:{
            $top_random_records[] = '<a class="w3-btn hidden-md hidden-sm hidden-xs" href="http://'.$_SERVER['SERVER_NAME'].'/'.mb_strtolower ($row['kw'], "UTF-8").'">'.mb_strtolower ($row['kw'], "UTF-8").'</a>';
            break;
        }
        case 7:{
            $top_random_records[] = '<a class="w3-btn hidden-md hidden-sm hidden-xs" href="http://'.$_SERVER['SERVER_NAME'].'/'.mb_strtolower ($row['kw'], "UTF-8").'">'.mb_strtolower ($row['kw'], "UTF-8").'</a>';
            break;
        }
        /*******************************/
        case 8:{
            $bottom_random_records[] = '<a class="w3-btn hidden-xs" href="http://'.$_SERVER['SERVER_NAME'].'/'.mb_strtolower ($row['kw'], "UTF-8").'">'.mb_strtolower ($row['kw'], "UTF-8").'</a>';
            break;
        }
        case 9:{
            $bottom_random_records[] = '<a class="w3-btn hidden-xs" href="http://'.$_SERVER['SERVER_NAME'].'/'.mb_strtolower ($row['kw'], "UTF-8").'">'.mb_strtolower ($row['kw'], "UTF-8").'</a>';
            break;
        }
        case 10:{
            $bottom_random_records[] = '<a class="w3-btn hidden-xs" href="http://'.$_SERVER['SERVER_NAME'].'/'.mb_strtolower ($row['kw'], "UTF-8").'">'.mb_strtolower ($row['kw'], "UTF-8").'</a>';
            break;
        }
        case 11:{
            $bottom_random_records[] = '<a class="w3-btn hidden-xs" href="http://'.$_SERVER['SERVER_NAME'].'/'.mb_strtolower ($row['kw'], "UTF-8").'">'.mb_strtolower ($row['kw'], "UTF-8").'</a>';
            break;
        }
        case 12:{
            $bottom_random_records[] = '<a class="w3-btn hidden-sm hidden-xs" href="http://'.$_SERVER['SERVER_NAME'].'/'.mb_strtolower ($row['kw'], "UTF-8").'">'.mb_strtolower ($row['kw'], "UTF-8").'</a>';
            break;
        }
        case 13:{
            $bottom_random_records[] = '<a class="w3-btn hidden-md hidden-sm hidden-xs" href="http://'.$_SERVER['SERVER_NAME'].'/'.mb_strtolower ($row['kw'], "UTF-8").'">'.mb_strtolower ($row['kw'], "UTF-8").'</a>';
            break;
        }
        case 14:{
            $bottom_random_records[] = '<a class="w3-btn hidden-md hidden-sm hidden-xs" href="http://'.$_SERVER['SERVER_NAME'].'/'.mb_strtolower ($row['kw'], "UTF-8").'">'.mb_strtolower ($row['kw'], "UTF-8").'</a>';
            break;
        }
    }
    $count++;
}

$page_template = str_replace("[TOP-RANDOM-RECORDS]", implode("&nbsp;", $top_random_records), $page_template);
$page_template = str_replace("[BOTTOM-RANDOM-RECORDS]", implode("&nbsp;", $bottom_random_records), $page_template);

$page_template = str_replace("[PLACEHOLDER]", $placeholder, $page_template);
$page_template = str_replace("[LOADING-TEXT]", "Loading...", $page_template);

$page_template = str_replace("[CONTACTS]", $contact_with_administrator_text, $page_template);

$page_template = str_replace("[MODAL-CLOSE]", $modal_close, $page_template);




if(is_page()){
  include_once('page.php');
}else
if(is_archive_page()){
  include_once('archive_page.php');
}else
if(is_home()){
  include_once('home.php');
}else{
    header("Content-Type: text/html; charset=utf-8");
    header($_SERVER['SERVER_PROTOCOL']." 404 Not Found\r\n");
    include_once('404.php');
    exit();
}



echo $page_template;


// генерация карты сайта
//$cur_cache_time = strtotime($row['cachetime']);
$curtime = time();

$sitemap_last_generation_time = file_get_contents("sitemap_last_generation_time.inc");
if(($curtime-$sitemap_last_generation_time) > $sitemap_generation_period){
    // сгенерить карту
    // обновить файл текущим временеим
    try{
        include_once("sitemap_generation.php");
        file_put_contents("sitemap_last_generation_time.inc", $curtime);
        file_put_contents("robots.txt", "User-agent: *".PHP_EOL."Disallow: /page/".PHP_EOL."User-Agent: *".PHP_EOL."Sitemap: httр://".$_SERVER['SERVER_NAME']."/sitemap.xml");
    }catch (Exception $e){
        //
    }

}

mysqli_close($db);
?>