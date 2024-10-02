<?php

 class TgDTO
{
    public readonly string $chatId;
    public readonly string $text;

    public function __construct(array $update)
    {
        $this->chatId = $update['message']['chat']['id'];
        $this->text = mb_strtolower($update['message']['text']);
    }


}