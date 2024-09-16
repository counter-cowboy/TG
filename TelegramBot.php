<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class TelegramBot
{
    protected string $token = "5921769353:AAH5-UgHdLYfubuKSyZffWm2Y-sKsLsDGjY";
    protected $offset;

    protected function query($method, $params = [])
    {
        $url = "https://api.telegram.org/bot" . $this->token . "/" . $method;

        if (!empty($params)) {
            $url .= "?" . http_build_query($params);
        }
        $client = new Client([
            'base_uri' => $url
        ]);
        $result = $client->request('GET');
        return json_decode($result->getBody(), true);
    }

    public function getUpdates()
    {
        $response = $this->query('getUpdates',['offset'=>$this->offset+1]);

        if (!empty($response['result'])) {
            $this->offset = $response['result'][count($response['result']) - 1]['update_id'];
        }
        return $response['result'];
    }

    public function sendMessage($text, $chat_id)
    {
        $response = $this->query('sendMessage', [
            'chat_id' => $chat_id,
            'text' => $text,
        ]);
        return $response;
    }


}