<?php
$mix = explode("/", urldecode($_SERVER['REQUEST_URI']));

$result = mysqli_query($db, "SELECT * FROM cache WHERE kw='".mysqli_real_escape_string($db, $mix[1])."'");
$num_rows = mysqli_num_rows($result);
$row=mysqli_fetch_assoc($result);
if($num_rows == 0){
    header("Content-Type: text/html; charset=utf-8");
    header($_SERVER['SERVER_PROTOCOL']." 404 Not Found\r\n");
    include_once('404.php');
    exit();
}

$content = "";
$items = json_decode($row['data']);
$count = 0;
foreach($items as $it){
    $content .= '<div class="col-sm-6 col-md-2">
                        <div class="thumbnail" title="'.$it[0].': '.$it[5].'">
                        <img onclick="modal_init(\''.$it[6].'\', \''.str_replace(" ", "-", $row['kw'])."-".$count.'.'.$it[4].'\')" data-toggle="modal" data-target="#full-view" onerror="imageerrorloading(this)" src="'.$it[6].'" alt="'.$it[0].': '.$it[5].'" title="'.$it[0].': '.$it[5].'" class="hidden-lg hidden-md hidden-sm visible-xs">
                        <div onclick="modal_init(\''.$it[6].'\', \''.str_replace(" ", "-", $row['kw'])."-".$count.'.'.$it[4].'\')" data-toggle="modal" data-target="#full-view" class="thumbnail-div hidden-xs visible-sm visible-md visible-lg" style="background: url('.$it[7].') center; background-size: cover; "></div>
                        <div class="caption">
                            <div class="file-resolution">'.$file_resolution_text.': '.$it[1].'X'.$it[2].'</div>
                            <div class="file-size">'.$file_size.': '.$it[3].'</div>
                            <div class="file-type">'.$file_type.': '.$it[4].'</div>
                            <div class="file-name">'.$file_name.': <span class="file-name-span">'.str_replace(" ", "-", $row['kw'])."-".$count.'.'.$it[4].'</span></div>
                            <!--<noindex>--> <a target="_blank" rel="nofollow" class="download" href="http://'.$_SERVER['SERVER_NAME'].'/download.php?file='.urlencode($it[6]).'&type='.$it[4].'&name='.urlencode(mb_strtolower (str_replace(" ", "-", str_replace(" ", "-", $row['kw'])."-".$count), "UTF-8")).'">'.$download_text.'</a> <!--</noindex>-->
                        </div>
                    </div>
                </div>';
$count++;
}

$page_template = str_replace("[TITLE]", $before_title.mb_ucwords($row['kw']).$after_title, $page_template);
$page_template = str_replace("[H1]", "<h1>".$row['kw']."</h1>", $page_template);
$page_template = str_replace("[META]", '', $page_template);
$page_template = str_replace("[TITLE]", "TITLE", $page_template);
$page_template = str_replace("[SERVER-NAME]", $_SERVER['SERVER_NAME'], $page_template);
$page_template = str_replace("[PAGINATION]", "", $page_template);
$page_template = str_replace("[CONTENT]", $content, $page_template);
?>