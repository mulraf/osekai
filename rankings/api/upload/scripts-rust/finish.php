<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "//global/php/functions.php");
include("base_api.php");

// this needs to fill out MedalListing.php. it's literally duplicate data kind of smashed together so i won't bother bade with it
$url = "https://discord.com/api/webhooks/1017796683532341378/GLyAd_sTEi1mT-GVAt5WszGEBwLAnZLuCtvTYb_vegyhbqrRVl07emhwwIENf7MrNnxX";
$data = array('content' => 'scripts-rust upload<br>' . json_encode($_POST));
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);