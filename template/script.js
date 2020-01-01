function start_search(){

var search_input = document.getElementById("search-input");

var h1_row = document.getElementById("h1-row");
var content_row = document.getElementById("content-row");
var pagination_row = document.getElementById("pagination-row");
var loader_row = document.getElementById("loader-row");

if(search_input.value.length<3)return;

if(h1_row!=null){
    h1_row.style.display="none";
}
if(content_row!=null){
    content_row.style.display="none";
}
if(pagination_row!=null){
    pagination_row.style.display="none";
}

loader_row.style.display = "block";
/***********************************/
var req = getXmlHttp();
req.onreadystatechange = function() {
    if (req.readyState == 4) {
        if(req.status == 200) {
            if(req.responseText==''){
                    h1_row.style.display="block";
                    content_row.style.display="block";
                    pagination_row.style.display="block";

                    loader_row.style.display = "none";
                    alert("notfound");
                }else{
                    window.location.href = "http://"+document.domain+"/" + decodeURIComponent(req.responseText);
                }
			}
		}
	}
	req.open('GET', '/search.php?q=' + encodeURIComponent(search_input.value), true);
	req.send(null);
}

function getXmlHttp(){
  var xmlhttp;
  try {
    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
  } catch (e) {
    try {
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (E) {
      xmlhttp = false;
    }
  }
  if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
    xmlhttp = new XMLHttpRequest();
  }
  return xmlhttp;
}
function imageerrorloading(image){
    image.src="/template/images/picture-not-available.jpg";
}

function modal_init(url, name){
    var full_view = document.getElementById("full-view");
    var modal_title = document.getElementById("modal-title");
    var modal_body = document.getElementById("modal-body");

    full_view.style.display = "block";

    modal_title.innerText = name;
    modal_body.innerHTML = "<p><img onerror='imageerrorloading(this)' style='width:100%' src='"+url+"' /></p>";
}