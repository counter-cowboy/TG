<?php

require_once 'TeleBot.php';
require_once 'UserAnswersJsonService.php';

ini_set('max_execution_time', '300');

$telebot = new TeleBot();
$service = new UserAnswersJsonService();

while (true) {

    $updates = $telebot->getUpdates();

    foreach ($updates as $update) {

        $chatId = $update['message']['chat']['id'];
        $text = strtolower($update['message']['text']);

        if ($text === "/start") {
            $telebot->sendMessage($chatId, "Привет, хочешь доступ? Пиши: Хочу доступ");


        } elseif (mb_strtolower($update['message']['text']) === 'хочу доступ') {
            if (!$service->isUserAnswered($chatId)) {
                $telebot->sendMessage($chatId, "Реши пример, что дал выше.");
            }

            $number1 = rand(1, 50);
            $number2 = rand(1, 50);
            $correctAnswer = $number1 + $number2;

            $telebot->sendMessage($chatId, "Реши пример: $number1 + $number2");

            $service->saveAnswer($chatId, $correctAnswer);

        } elseif ($service->isSetChatId($chatId) && $service->isCompareText($chatId, $text)) {
            $telebot->sendMessage($chatId, "https://www.youtube.com/watch?v=jxCK3PbnL2U");

            $service->unsetUser($chatId);
        } else
            $telebot->sendMessage($chatId, "Пробуй ещё раз!");

    }
}