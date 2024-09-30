<?php

class Service
{
    public function saveAnswer(string $chatId, string $correctAnswer): void
    {
        $newAnswer= [
          'id'=>$chatId,
          'answer'=>$correctAnswer
        ];

        $answers = json_decode(file_get_contents('tg.json'), true);

        $answers[] = $newAnswer;
        file_put_contents('tg.json', json_encode($answers));
    }

    public function unsetUser(string $chatId): void
    {
        $answersToWrite = json_decode(file_get_contents('tg.json'), true);

        foreach ($answersToWrite as $key=>$answer) {

            if ($answer['id']===$chatId){
                unset($answersToWrite[$key]);
                file_put_contents('tg.json', json_encode($answersToWrite));
                break;
            }
        }
    }

    public function isSetChatId(string $chatId): bool
    {
        $users=json_decode(file_get_contents('tg.json'), true);

        $result=false;
        foreach ($users as  $user) {

            if ($user['id'] ==$chatId){

                $result=true;
                break;
            }
        }
        return $result;
    }

    public function isCompareText(string $chatId, string $text): bool
    {
        $users = json_decode(file_get_contents('tg.json'), true);
        $result=false;

        foreach ($users as  $user){

            if ($user['id']==$chatId && $user['answer']==$text){
                $result=true;
                break;
            }
        }
        return $result;
    }

}