<?php
function is_page(){
    $mix = explode("/", $_SERVER['REQUEST_URI']);
    if(count($mix)==2 && $mix[0] == "" && preg_match("/\/[\p{L}0-9\\s]+/", urldecode($_SERVER['REQUEST_URI']))){
        return true;
    }else{
        return false;
    }
}

function is_archive_page(){
    if(preg_match("/\/page\/[0-9]+/", $_SERVER['REQUEST_URI'])){
        return true;
    }else{
        return false;
    }
}

function is_home(){
    if($_SERVER['REQUEST_URI'] == '/'){
        return true;
    }else{
        return false;
    }
}
function mb_ucwords($str) {
$str = mb_convert_case($str, MB_CASE_TITLE, "UTF-8");
return ($str);
}

function get_web_page( $url )
{
  $uagent = "Opera/9.80 (Windows NT 6.1; WOW64) Presto/2.12.388 Version/12.14";

  $ch = curl_init( $url );

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   // возвращает веб-страницу
  curl_setopt($ch, CURLOPT_HEADER, 0);           // не возвращает заголовки
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);   // переходит по редиректам
  curl_setopt($ch, CURLOPT_ENCODING, "");        // обрабатывает все кодировки
  curl_setopt($ch, CURLOPT_USERAGENT, $uagent);  // useragent
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // таймаут соединения
  curl_setopt($ch, CURLOPT_TIMEOUT, 120);        // таймаут ответа
  curl_setopt($ch, CURLOPT_MAXREDIRS, 10);       // останавливаться после 10-ого редиректа
  //curl_setopt($ch, CURLOPT_COOKIE, "SRCHD=AF=NOFORM; SRCHUID=V=2&_EDGE_V=1;&ADLT=OFF&UTC=120; _ITAB=STAB=FAV; _IFAV=COUNT=0&SEEALL=NaN;");
  curl_setopt($ch, CURLOPT_COOKIE, "SRCHUID=V=2&dmnchg=1; SRCHD=AF=NOFORM;_EDGE_V=1;DPR=1&ADLT=OFF&_ITAB=STAB=FAV; _IFAV=COUNT=0&SEEALL=NaN;dmnchg=1");
  
  $content = curl_exec( $ch );
  $err     = curl_errno( $ch );
  $errmsg  = curl_error( $ch );
  $header  = curl_getinfo( $ch );
  curl_close( $ch );

  $header['errno']   = $err;
  $header['errmsg']  = $errmsg;
  $header['content'] = $content;
  //return $header;
  return $content;
}
?>