<?php

use GuzzleHttp\Exception\GuzzleException;

require 'vendor/autoload.php';
require 'TelegramBot.php';

$telegramApi = new TelegramBot();


//echo $updates;
//print_r($updates);

//print_r($updates['result'][0]['message']['chat']['id']);

while (true) {
    sleep(1);

    $updates = $telegramApi->getUpdates();

    foreach ($updates as $update) {

        if ($update['message']['text'] === "/start") {

            $userQuestionId = $update['message']['chat']['id'];

            $telegramApi->sendMessage("Count this '2' + 2", $userQuestionId);
        }


//        $telegramApi->sendMessage('Hi!', $update['message']['chat']['id']);
    }
    foreach ($updates as $update) {
        if ($update['message']['chat']['id'] == $userQuestionId && $update['message']['text'] == "22") {
            $telegramApi->sendMessage('You are right!!', $userQuestionId);
        }
    }
}
