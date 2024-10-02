<?php
require_once 'GetTgToken.php';
require_once 'HttpQuery.php';

class TeleBot
{
    private string $token;
    public int $offset = 0;
    public string $baseUrl;
    public HttpQuery $request;

    public function __construct()
    {
        $this->token = GetTgToken::getToken();
        $this->baseUrl = "https://api.telegram.org/bot";
        $this->request = new HttpQuery();
    }

    public function sendMessage(string $chatId, string $text): string
    {
        $url = $this->baseUrl . $this->token . "/sendMessage?";
        $data = ['chat_id' => $chatId, 'text' => $text];

        return $this->request->httpPost($url, $data);
    }

    private function query(array $params = []): array
    {
        $url = $this->baseUrl . $this->token . "/getUpdates";

        if (!empty($params)) {
            $url .= "?" . http_build_query($params);
        }

        $result = $this->request->httpGet($url);
        return json_decode($result, true);
    }

    public function getUpdates(): array
    {
        $response = $this->query(['offset' => $this->offset + 1]);

        if (!empty($response['result'])) {
            $this->offset = $response['result'][count($response['result']) - 1]['update_id'];
        }
        return $response['result'];
    }
}