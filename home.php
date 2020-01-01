<?php


/*фото на главной $total_images_on_home*/

$result = mysqli_query($db, "SELECT * FROM (SELECT * FROM cache ORDER BY id DESC LIMIT ".$total_item_on_home.") as tmp ORDER BY id DESC");
while ( $home_postrow[] = mysqli_fetch_array($result));
for($i = 0; $i < count($home_postrow)-1; $i++)
{
    $one_item = json_decode($home_postrow[$i]['data']);
    //echo $one_image[0][6]
    $home_items .= '<div class="col-sm-6 col-md-2">
                        <div class="thumbnail">
                        <a href="http://'.$_SERVER['SERVER_NAME'].'/'.mb_strtolower ($home_postrow[$i]['kw'], "UTF-8").'"><img onerror="imageerrorloading(this)" alt="'.$home_postrow[$i]['kw'].'" title="'.$home_postrow[$i]['kw'].'" src="'.$one_item[0][6].'" class="hidden-lg hidden-md hidden-sm visible-xs">
                        <div class="thumbnail-div hidden-xs visible-sm visible-md visible-lg" style="background: url('.$one_item[0][7].') center; background-size: cover; "></div></a>
                        <div class="caption">
                            <div class="image-title">'.$home_postrow[$i]['kw'].'</div>
                        </div>
                    </div>
                </div>';
}

$page_template = str_replace("[CONTENT]", $home_items, $page_template);

$last_page = intval(($total_records - 1) / $total_item_on_home) + 1;
$pagination = '<div class="row" id="pagination-row">
                <div class="col-md-12 text-center">
                    <ul class="pagination">
                        <li class="active">
                            <a href="http://'.$_SERVER['SERVER_NAME'].'/page/1">1</a>
                        </li>
                        <li>
                            <a href="http://'.$_SERVER['SERVER_NAME'].'/page/2">2</a>
                        </li>
                        <li>
                            <a href="http://'.$_SERVER['SERVER_NAME'].'/page/3">3</a>
                        </li>
                        <li>
                            <a href="http://'.$_SERVER['SERVER_NAME'].'/page/2">&rsaquo;</a>
                        </li>
                        <li>
                            <a href="http://'.$_SERVER['SERVER_NAME'].'/page/'.$last_page.'">&raquo;</a>
                        </li>
                    </ul>
                </div>
            </div>';
$page_template = str_replace("[PAGINATION]", $pagination, $page_template);
$page_template = str_replace("[TITLE]", $home_title, $page_template);
$page_template = str_replace("[META]", "", $page_template);
$page_template = str_replace("[SERVER-NAME]", $_SERVER['SERVER_NAME'], $page_template);
$page_template = str_replace("[H1]", "", $page_template);
?>