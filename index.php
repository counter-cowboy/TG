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

 function query($method, $params=[])
{
    global $token;
    $url = "https://api.telegram.org/bot" . $token . "/" . $method;

    if (!empty($params)) {
        $url .= "?" . http_build_query($params);
    }

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $result = curl_exec($ch);

    curl_close($ch);

    return json_decode($result, true);
}

function getUpdates()
{
    global $offset;
    $response = query('getUpdates',['offset'=>$offset+1]);

    if (!empty($response['result'])) {
        $offset = $response['result'][count($response['result']) - 1]['update_id'];
    }
    return $response['result'];
}

while (true) {

    $updates=getUpdates();

    foreach ($updates as $update) {

        if (isset($update['message'])) {
            $chatId = $update['message']['chat']['id'];
            $text = $update['message']['text'];

            if ($text === "/start") {
                sendMessage($chatId, "Привет, хочешь доступ? Пиши: Хочу доступ");

            } elseif ($text == 'Хочу доступ') {
                $number1 = rand(1, 50);
                $number2 = rand(1, 50);
                $correctAnswer = $number1 + $number2;

                sendMessage($chatId,"Реши пример: $number1 + $number2");

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