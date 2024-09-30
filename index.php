<?php

require_once 'TeleBot.php';

ini_set('max_execution_time', '300');

$telebot = new TeleBot();

while (true) {

    $updates = $telebot->getUpdates();

    foreach ($updates as $update) {

        if (isset($update['message'])) {
            $chatId = $update['message']['chat']['id'];
            $text = strtolower($update['message']['text']);

            if ($text === "/start") {
                $telebot->sendMessage($chatId, "Привет, хочешь доступ? Пиши: Хочу доступ");

            }
            elseif (mb_strtolower($update['message']['text']) === 'хочу доступ') {
                $number1 = rand(1, 50);
                $number2 = rand(1, 50);
                $correctAnswer = $number1 + $number2;

                $telebot->sendMessage($chatId, "Реши пример: $number1 + $number2");

                $answers[] = json_decode(file_get_contents('tg.json'), true);

                $answers[$chatId] = $correctAnswer;
                file_put_contents('tg.json', json_encode($answers));

            }
            elseif (isset(json_decode(file_get_contents('tg.json'), true)[$chatId])
                && $text == json_decode(file_get_contents('tg.json'), true)[$chatId]) {

                $telebot->sendMessage($chatId, "https://www.youtube.com/watch?v=jxCK3PbnL2U");
                $answers[] = json_decode(file_get_contents('tg.json'), true);

                unset($answers[$chatId]);
                file_put_contents('tg.json', json_encode($answers));

            } else {
                $telebot->sendMessage($chatId, "Пробуй ещё раз!");
            }
        }
    }
    sleep(.1);
}