<?php
require 'vendor/autoload.php';
require 'TelegramBot.php';


$telegramApi=new TelegramBot();
$updates=$telegramApi->getUpdates();
print_r($updates);

//
////require 'vendor/autoload.php';
//const TG_TOKEN = "5921769353:AAH5-UgHdLYfubuKSyZffWm2Y-sKsLsDGjY";
//const TG_USER_ID = 711391879;
//
//
//
//$getQuery = [
//    "chat_id" => TG_USER_ID,
//    "text" => "New test message\nNew test message\nNew test message",
//    'parse_mode' => 'html'
//];
//
////$ch = curl_init("https://api.telegram.org/bot" . TG_TOKEN . '/sendMessage?' . http_build_query($getQuery));
//$ch = curl_init("https://api.telegram.org/bot" . TG_TOKEN . '/getUpdates');
//
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//curl_setopt($ch, CURLOPT_HEADER, false);
//$resultQuery = curl_exec($ch);
//
//echo $resultQuery;
//$result=json_decode($resultQuery,true);
//
////echo json_encode($result['result']['chat']['username']);
//
//curl_close($ch);













//00