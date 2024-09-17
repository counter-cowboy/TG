<?php

require_once 'TeleBot.php';
ini_set('max_execution_time', 300);

$telebot = new TeleBot();

while (true) {

    $updates = $telebot->getUpdates();

    foreach ($updates as $update) {

        if (isset($update['message'])) {
            $chatId = $update['message']['chat']['id'];
            $text = $update['message']['text'];

            if ($text === "/start") {
                $telebot->sendMessage($chatId, "Привет, хочешь доступ? Пиши: Хочу доступ");

            } elseif ($text == 'Хочу доступ') {
                $number1 = rand(1, 50);
                $number2 = rand(1, 50);
                $correctAnswer = $number1 + $number2;

                $telebot->sendMessage($chatId, "Реши пример: $number1 + $number2");

                $answers[$chatId] = $correctAnswer;

            } elseif (isset($answers[$chatId]) && $text == $answers[$chatId]) {

                $telebot->sendMessage($chatId, "https://www.youtube.com/watch?v=jxCK3PbnL2U");
                unset($answers[$chatId]);

            } else {
                $telebot->sendMessage($chatId, "Пробуй ещё раз!");
            }
        }
    }
    sleep(1);
}