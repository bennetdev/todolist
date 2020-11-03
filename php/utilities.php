<?php
function replaceChars($string){
	$string = str_replace("<", "&lt;", $string);
	$string = str_replace(">", "&gt;", $string);
	$string = str_replace("ä", "&auml;", $string);
	$string = str_replace("Ä", "&Auml;", $string);
	$string = str_replace("ö", "&ouml;", $string);
	$string = str_replace("Ö", "&Ouml;", $string);
	$string = str_replace("ü", "&uuml;", $string);
	$string = str_replace("Ü", "&Uuml;", $string);
}