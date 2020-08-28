<?php
require_once "SteamID/SteamID.php";
require_once('SteamID/bootstrap.php');
SteamID\SteamID::init();
$steamid3 = SteamID\SteamID::toSteam3($steamprofile['steamid']);

$mysteamid3 = substr("$steamid3", 5, 9);

$link = false;
$count = substr_count($data['tradelink'], "$mysteamid3");

function parse_url_if_valid($url)
{
    // Массив с компонентами URL, сгенерированный функцией parse_url()
    $arUrl = parse_url($url);
    // Возвращаемое значение. По умолчанию будет считать наш URL некорректным.
    $ret = null;

    // Если не был указан протокол, или
    // указанный протокол некорректен для url
    if (!array_key_exists("scheme", $arUrl)
        || !in_array($arUrl["scheme"], array("http", "https")))
        // Задаем протокол по умолчанию - http
        $arUrl["scheme"] = "http";

    // Если функция parse_url смогла определить host
    if (array_key_exists("host", $arUrl) &&
        !empty($arUrl["host"]))
        // Собираем конечное значение url
        $ret = sprintf("%s://%s%s", $arUrl["scheme"],
            $arUrl["host"], $arUrl["path"]);

    // Если значение хоста не определено
    // (обычно так бывает, если не указан протокол),
    // Проверяем $arUrl["path"] на соответствие шаблона URL.
    else if (preg_match("/^\w+\.[\w\.]+(\/.*)?$/", $arUrl["path"]))
        // Собираем URL
        $ret = sprintf("%s://%s", $arUrl["scheme"], $arUrl["path"]);

    // Если url валидный и передана строка параметров запроса
    if ($ret && empty($ret["query"]))
        $ret .= sprintf("?%s", $arUrl["query"]);

    return $ret;
}
$url = parse_url_if_valid($_POST['site-url']);
if($count == 1 AND $url)
    $link = true;
?>