<?php

 class TgDTO
{
    public readonly string $chatId;
    public readonly string $text;

    public function __construct(string $id, string $message)
    {
        $this->chatId = $id ;
        $this->text = $message;
    }


}