<?php

$token = "5921769353:AAH5-UgHdLYfubuKSyZffWm2Y-sKsLsDGjY";

$updateUrl = "https://api.telegram.org/bot{$token}/getUpdates";
$offset = 0;

function sendMessage($chatId, $text)
{
    global $token;
    $url = "https://api.telegram.org/bot{$token}/sendMessage?";
    $data = ['chat_id' => $chatId, 'text' => $text];
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

while (true) {
    $offsetParam=$offset+1;
    $updateUrl .= "?offset=$offsetParam";
    $response = file_get_contents($updateUrl);
    $updates = json_decode($response, true);
    if (!empty($updates['result'])) {
        $offset = $updates['result'][count($updates['result']) - 1]['update_id'];
    }

    foreach ($updates['result'] as $update) {

        if (isset($update['message'])) {
            $chatId = $update['message']['chat']['id'];
            $text = $update['message']['text'];

            if ($text === "/start") {
                sendMessage($chatId, "Привет, хочешь доступ? ПишиЖ Хочу доступ");
            } elseif ($text == 'Хочу доступ') {
                $number1 = rand(1, 50);
                $number2 = rand(1, 50);
                $correctAnswer = $number1 + $number2;

                sendMessage("Реши пример: $number1 + $number2");

                $answers[$chatId] = $correctAnswer;
            } elseif (isset($answers[$chatId]) && $text == $answers[$chatId]) {
                sendMessage($chatId, "https://www.youtube.com/watch?v=jxCK3PbnL2U");
                unset($answers[$chatId]);
            } else {
                sendMessage($chatId, "Пробуй ещё раз!");
            }
        }
    }
    sleep(1);
}