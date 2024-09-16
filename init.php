<?php



require 'TelegramBot.php';

ini_set('max_execution_time', 300);

$telegramApi = new TelegramBot();

while (true) {
    sleep(1);

    $updates = $telegramApi->getUpdates();

    foreach ($updates as $update) {


            $chatId = $update['message']['chat']['id'];
            $text = $update['message']['text'];


            if ($text === "/start") {
                $telegramApi->sendMessage("Привет, хочешь доступ? Пиши: Хочу доступ", $chatId);

            } elseif ($text == 'Хочу доступ') {
                $number1 = rand(1, 50);
                $number2 = rand(1, 50);
                $correctAnswer = $number1 + $number2;

                $telegramApi->sendMessage("Реши пример: $number1 + $number2", $chatId);
                echo $correctAnswer;

                $answers[$chatId] = $correctAnswer;

            } elseif (isset($answers[$chatId]) && $text == $answers[$chatId]) {
                $telegramApi->sendMessage("https://www.youtube.com/watch?v=jxCK3PbnL2U", $chatId);
                unset($answers[$chatId]);

            } else {
                $telegramApi->sendMessage("Пробуй ещё раз!", $chatId);
            }

    }


//    foreach ($updates as $update) {
//
//        if ($update['message']['text'] === "/start") {
//
//            $userQuestionId = $update['message']['chat']['id'];
//
//            $telegramApi->sendMessage("Count this '2' + 2", $userQuestionId);
//        }
//    }
//
//    foreach ($updates as $update) {
//
//        if ($update['message']['chat']['id'] == $userQuestionId && $update['message']['text'] == "22") {
//            $telegramApi->sendMessage('You are right!!', $userQuestionId);
//        }
////        if ($update['message']['chat']['id'] == $userQuestionId && $update['message']['text'] != "22"){
////            $telegramApi->sendMessage('You are wrong(((', $userQuestionId);
////        }
//    }
}
