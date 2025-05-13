<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Bot model
 */
class Bot extends Model
{
    const IMG = '/frontend/web/images/bot_univer.jpg';

    public static function telegram($telegram)
    {
        $text = $telegram->input->message->text;
        $username = $telegram->input->message->chat->username;
        $telegram_id = $telegram->input->message->chat->id;

        $user = User::findOne([
            'telegram_id' => $telegram_id,
            'status' => [5,9,10]
        ]);
        if ($user) {
            if ($user->status == 10) {

            } elseif ($user->status == 9) {

            } else {

            }
        } else {

        }
        return true;
    }



    public static function sendPhone($telegram, $telegram_id)
    {
        $photoPath = Yii::getAlias('@frontend/web/images/new_bino.jpg');

        return $telegram->sendPhoto([
            'chat_id' => $telegram_id,
            'photo' => curl_file_create($photoPath),
            'caption' => "🇺🇿 *TASHKENT PERFECT UNIVERSITY* haqida rasm\n\nTelefon raqamingizni yuboring:",
            'parse_mode' => 'Markdown',
            'reply_markup' => json_encode([
                'keyboard' => [[
                    [
                        'text' => "☎️ Telefon raqamni yuborish",
                        'request_contact' => true
                    ]
                ]],
                'resize_keyboard' => true,
                'one_time_keyboard' => true,
            ])
        ]);
    }
}
