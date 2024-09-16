<?php

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

        $result = file_get_contents($url);
        return json_decode($result, true);
    }

    public function getUpdates()
    {
        $response = $this->query('getUpdates',['offset'=>$this->offset+1]);

        if (!empty($response['result'])) {
            $this->offset = $response['result'][count($response['result']) - 1]['update_id'];
        }
        return $response['result'];
    }

    public function sendMessage($text, $chatId)
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


}