<?
$view=$_GET['view'];
$destino=str_replace("|", "?view=", $view);
$destino=str_replace("_", ".", $destino);
header("Location: $destino");
die();

