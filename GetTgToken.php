<?php

class GetTgToken
{
    public static function getToken():string
    {
        return file_get_contents('api_token');
    }

}