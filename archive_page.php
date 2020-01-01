<?php
$mix = explode("/", $_SERVER['REQUEST_URI']);

$page = $mix[2];

$total = intval(($total_records - 1) / $total_items_on_cat_page) + 1;
// Определяем начало сообщений для текущей страницы
$page = intval($page);
// Если значение $page меньше единицы или отрицательно
// переходим на первую страницу
// А если слишком большое, то переходим на последнюю
if(empty($page) or $page < 0) $page = 1;
  if($page > $total) $page = $total;
// Вычисляем начиная к какого номера
// следует выводить сообщения
$start = $page * $total_items_on_cat_page - $total_items_on_cat_page;
// Выбираем $num сообщений начиная с номера $start
$result = mysqli_query($db, "SELECT * FROM cache LIMIT $start, $total_items_on_cat_page");
// В цикле переносим результаты запроса в массив $postrow
while ( $postrow[] = mysqli_fetch_array($result));

$archive_content = "";
for($i = 0; $i < count($postrow)-1; $i++)
{
    $one_item = json_decode($postrow[$i]['data']);
    $archive_content .= '<div class="col-sm-6 col-md-2">
                        <div class="thumbnail">
                        <a href="http://'.$_SERVER['SERVER_NAME'].'/'.mb_strtolower ($postrow[$i]['kw'], "UTF-8").'"><img onerror="imageerrorloading(this)" src="'.$one_item[0][6].'" alt="'.$postrow[$i]['kw'].'" title="'.$postrow[$i]['kw'].'" class="hidden-lg hidden-md hidden-sm visible-xs">
                        <div class="thumbnail-div hidden-xs visible-sm visible-md visible-lg" style="background: url('.$one_item[0][7].') center; background-size: cover; "></div></a>
                        <div class="caption">
                            <div class="image-title">'.$postrow[$i]['kw'].'</div>
                        </div>
                    </div>
                </div>';
}

if ($page != 1) $pervpage = '<li><a href="http://'.$_SERVER['SERVER_NAME'].'/page/1">&laquo;</a></li>
                               <li><a href="http://'.$_SERVER['SERVER_NAME'].'/page/'.($page - 1).'">&lsaquo;</a></li>';
// Проверяем нужны ли стрелки вперед
if ($page != $total) $nextpage = '<li><a href="http://'.$_SERVER['SERVER_NAME'].'/page/'.($page + 1).'">&rsaquo;</a></li>
                                   <li><a href="http://'.$_SERVER['SERVER_NAME'].'/page/'.$total.'">&raquo;</a></li>';

// Находим две ближайшие станицы с обоих краев, если они есть
if($page - 2 > 0) $page2left = '<li><a href="http://'.$_SERVER['SERVER_NAME'].'/page/'.($page - 2).'">'.($page - 2).'</a></li>';
if($page - 1 > 0) $page1left = '<li><a href="http://'.$_SERVER['SERVER_NAME'].'/page/'.($page - 1).'">'.($page - 1).'</a></li>';
if($page + 2 <= $total) $page2right = '<li><a href="http://'.$_SERVER['SERVER_NAME'].'/page/'.($page + 2).'">'.($page + 2).'</a></li>';
if($page + 1 <= $total) $page1right = '<li><a href="http://'.$_SERVER['SERVER_NAME'].'/page/'.($page + 1).'">'.($page + 1).'</a></li>';

$pagination = '<div class="row" id="pagination-row"><div class="col-md-12 text-center"><ul class="pagination">'.$pervpage.$page2left.$page1left.'<li class="active"><a href="http://'.$_SERVER['SERVER_NAME'].'/page/'.$page.'">'.$page.'</a></li>'.$page1right.$page2right.$nextpage.'</ul></div></div>';

$page_template = str_replace("[CONTENT]", $archive_content, $page_template);
$page_template = str_replace("[PAGINATION]", $pagination, $page_template);
$page_template = str_replace("[META]", '<meta name="robots" content="noindex,follow" />', $page_template);

$page_template = str_replace("[TITLE]", $_SERVER['SERVER_NAME']."/page/".$page, $page_template);
$page_template = str_replace("[SERVER-NAME]", $_SERVER['SERVER_NAME'], $page_template);
$page_template = str_replace("[H1]", "", $page_template);
?>
