<?php
$fil = urldecode ($_GET['file']);
$title = urldecode($_GET['name']);
$type = urldecode($_GET['type']);
if($type=="animatedgif"){$type="gif";}
//$filename = preg_replace ("/[^\p{L}0-9]/iu","_",translitIt(base64_decode ($_GET['link'])));
	header("Content-Type: image/gif, image/jpeg, image/png, image/bmp, image/tiff");
	header("Content-Disposition: attachment; filename=\"".$title.".".$type."\"");
	readfile($fil);
	exit;
?>