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


        $gram = Telegram::findOne([
            'telegram_id' => $telegram_id,
            'is_deleted' => 0
        ]);
        if (!$gram) {
            $gram = new Telegram();
            $gram->telegram_id = $telegram_id;
            $gram->lang_id = 1;
            $gram->save(false);
        }

        $type = $gram->type;
        $step = $gram->step;
        $lang_id = $gram->lang_id;

        switch ($step) {
            case 0:
                $result = self::main($telegram, $lang_id, $gram);
                break;
            default:
                $errors[] = ['Type noto\'g\'ri yuborilgan'];
                break;
        }
        if (count($errors) == 0) {
            return ['is_ok' => true, 'telegram' => $result['telegram']];
        }
    }



    public static function main($telegram, $lang_id, $gram)
    {
        $telegram->sendMessage([
            'chat_id' => $gram->telegram_id,
            'text' => false,
            'parse_mode' => 'MarkdownV2',
            'reply_markup' => json_encode([
                'keyboard' => [
                    [
                        ['text' => self::getT("a1", $lang_id)],
                        ['text' => self::getT("a2", $lang_id)],
                    ],
                    [
                        ['text' => self::getT("a3", $lang_id)],
                    ]
                ],
                'resize_keyboard' => true,
            ])
        ]);
        return ['is_ok' => true, 'telegram' => $telegram];
    }

    public static function sendPhone($telegram, $telegram_id)
    {
        $photoUrl = "https://qabul.sarbon.university/frontend/web/images/new_bino.jpg";
        return $telegram->sendPhoto([
            'chat_id' => $telegram_id,
            'photo' => $photoUrl,
            'caption' => "🇺🇿 *TASHKENT SARBON UNIVERSITY* haqida rasm\n\nTelefon raqamingizni yuboring",
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


    public static function getSelectLanguageText($lang)
    {
        $array = [
            1 => "uz",
            2 => "en",
            3 => "ru",
        ];
        return isset($array[$lang]) ? $array[$lang] : null;
    }

    public static function getT($text, $lang_id)
    {
        $lang = self::getSelectLanguageText($lang_id);
        $array = [
            "a1" => [
                "uz" => "Universitet haqida",
                "ru" => "",
                "en" => "",
            ],
            "a2" => [
                "uz" => "Mavjud yo'nalishlar",
                "ru" => "",
                "en" => "",
            ],
            "a3" => [
                "uz" => "Ro'yhatdan o'tish",
                "ru" => "",
                "en" => "",
            ],
        ];
        if (isset($array[$text])) {
            return isset($array[$text][$lang]) ? $array[$text][$lang] : $text;
        } else {
            return $text;
        }
    }
}
