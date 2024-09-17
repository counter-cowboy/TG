<?php

class TeleBot
{

private $token = "5921769353:AAH5-UgHdLYfubuKSyZffWm2Y-sKsLsDGjY";
public $offset = 0;

public function sendMessage($chatId, $text)
{

    $url = "https://api.telegram.org/bot{$this->token}/sendMessage?";
    $data = ['chat_id' => $chatId, 'text' => $text];
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

private  function query($params=[])
{
    $url = "https://api.telegram.org/bot" . $this->token . "/" . 'getUpdates';

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

public function getUpdates()
{
    $response = $this->query(['offset'=>$this->offset+1]);

    if (!empty($response['result'])) {
        $this->offset = $response['result'][count($response['result']) - 1]['update_id'];
    }
    return $response['result'];
}

}