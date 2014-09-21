<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Demo News Ticker RSS Blog Dengan jQuery</title>
<script type="text/javascript" src="js/jquery.js"></script> 
<script type="text/javascript">
	function slideNews()
	{
	    akhir = $('ul#kotakticker li:last').hide().remove();
	    $('ul#kotakticker').prepend(akhir);
        $('ul#kotakticker li:first').slideDown("slow");
	}
	setInterval(slideNews, 5000);
</script> 
<style type="text/css"> 
	body{
		font-family:Tahoma, Arial;
		font-size:12px;
	}
	#content{
		width:420px;
		border:solid 1px #DEDEDE;
		-moz-border-radius: 5px; 
		-webkit-border-radius: 5px; 
		z-index: 9999 ;
		margin:0px auto;
	}
	#kotakticker{
		height:270px;
		width:420px;
		overflow:hidden;
		padding:10px 0px;
	}
	#title{
		height:20px;
		background-color:#EBFFAA;
		padding:5px;
		text-align:center;
		font-weight:bold;
	}
	#footer{
		height:20px;
		background-color:#EBFFAA;
		padding:5px;
		text-align:center;
		font-size:11px;
	}
 
	#kotakticker li{
		border:0; 
		margin:0;
		list-style:none;
		padding:10px;
		height:120px;
		list-style:none;
	}
 
	#kotakticker li:hover{
		background-color:#EBFFAA;
	}
	#kotakticker a{
		color:#000000;
		font-size:11px;
		text-decoration:none;
	}
	#kotakticker a:hover{
		color:#666600;
		text-decoration:underline;
	}
</style> 
 
</head> 
 
<body>
<div id="content">
<div id="title">Gede Lumbung RSS Blog</div>
<ul id="kotakticker"> 
<?php
    function startElement($parser, $name, $attrs) {
    global $insideitem, $tag, $title, $description, $link, $pubDate;
    if ($insideitem) {
    $tag = $name;
    } elseif ($name == "ITEM") {
    $insideitem = true;
    }
    }
    function endElement($parser, $name) {
    global $insideitem, $tag, $title, $description, $link, $pubDate, $i;
    if (!$i) {
    $i=0;
    }
    if (($name == "ITEM") && ($i<=3)) {
    $i++;
    printf("<li><b><a href='%s' target=_blank>%s</a></b><p style=' text-align:justify;'><span style='font-size:11px;'>%s %s</span></p></li>",
    trim($link),trim($title), substr($pubDate,0,16), $description);
    $title = "";
    $description = "";
    $link = "";
    $pubDate="";
    $insideitem = false;
    }
    }
    function characterData($parser, $data) {
    global $insideitem, $tag, $title, $description, $link, $pubDate;
    if ($insideitem) {
    switch ($tag) {
    case "TITLE":
    $title .= $data;
    break;
    case "DESCRIPTION":
    $description .= $data;
    break;
    case "LINK":
    $link .= $data;
    break;
    case "PUBDATE":
    $pubDate .= $data;
    break;
    }
    }
    }
    $url = "http://gedelumbung.com/wp-rss.php";
    $insideitem = false;
    $tag = "";
    $title = "";
    $description = "";
    $link = "";
    $pubDate ="";
    $xml_parser = xml_parser_create();
    xml_set_element_handler($xml_parser, "startElement", "endElement");
    xml_set_character_data_handler($xml_parser, "characterData");
    $fp = fopen($url,"r");
    while ($datarss = fread($fp, 100000))
    xml_parse($xml_parser, $datarss, feof($fp)) or die(sprintf("XML error: %s pada baris %d",
    xml_error_string(xml_get_error_code($xml_parser)),
    xml_get_current_line_number($xml_parser)));
    fclose($fp);
    xml_parser_free($xml_parser);
    ?>
	</ul> 
<div id="footer">www.gedelumbung.com</div>
</div>
</body>
</html>
