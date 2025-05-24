<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Bot model
 */
class Bot extends Model
{
    const CHAT_ID = 1841508935;
    const PHONE = '+998 94 505 52 50';

    const IMG = '/frontend/web/images/bot_univer.jpg';

    public static function telegram($telegram)
    {
        $username = $telegram->input->message->chat->username;
        $telegram_id = $telegram->input->message->chat->id;
        $token = Yii::$app->telegram->botToken;

        $gram = Telegram::findOne([
            'telegram_id' => $telegram_id,
            'is_deleted' => 0
        ]);
        if (!$gram) {
            $gram = new Telegram();
            $gram->telegram_id = $telegram_id;
            $gram->lang_id = 1;
            $gram->save(false);

            self::sendPhone($telegram, $gram);
        } else {
            $type = $gram->type;
            $step = $gram->step;
            $lang_id = $gram->lang_id;

//            self::setBotCommands($token, $lang_id);

            switch ($type) {
                case 0:
                    self::main($telegram, $lang_id, $gram);
                    break;
                case 2:
                    // Universitet haqida
                    self::main($telegram, $lang_id, $gram);
                    break;
                case 3:
                    // Mavjud yonalishlar
                    self::main($telegram, $lang_id, $gram);
                    break;
                case 4:
                    // Bot tilini ozgartirish
                    self::main($telegram, $lang_id, $gram);
                case 5:
                    // Ro'yhatdan o'tish
                    self::main($telegram, $lang_id, $gram);
                    break;
                default:
                    break;
            }
        }
    }



    public static function main($telegram, $lang_id, $gram)
    {
        try {
            if (json_encode($telegram->input->message->contact) != "null") {
                $contact = json_encode($telegram->input->message->contact);
                $contact_new = json_decode($contact);
                $phone = preg_replace('/[^0-9]/', '', $contact_new->phone_number);
                $phoneKod = substr($phone, 0, 3);
                if ($phoneKod != 998) {
                    return $telegram->sendMessage([
                        'chat_id' => $gram->telegram_id,
                        'text' => self::getT("a6", $lang_id),
                        'parse_mode' => 'HTML',
                        'reply_markup' => json_encode([
                            'keyboard' => [[
                                [
                                    'text' => self::getT("a7", $lang_id),
                                    'request_contact' => true
                                ]
                            ]],
                            'resize_keyboard' => true,
                            'one_time_keyboard' => true,
                        ])
                    ]);
                } else {
                    $gram->phone = "+" . $phone;
                    $gram->type = 1;
                    $gram->save(false);

                    return $telegram->sendMessage([
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
                                    ['text' => self::getT("a4", $lang_id)],
                                    ['text' => self::getT("a3", $lang_id)],
                                ]
                            ],
                            'resize_keyboard' => true,
                        ])
                    ]);
                }
            }
            return $telegram->sendMessage([
                'chat_id' => $gram->telegram_id,
                'text' => self::getT("a8", $lang_id),
                'parse_mode' => 'HTML',
            ]);
        } catch (\Exception $e) {
            return $telegram->sendMessage([
                'chat_id' => self::CHAT_ID,
                'text' => ['Ik main :( '.$e->getMessage()],
            ]);
        }
    }

    public static function sendPhone($telegram, $gram)
    {
        try {
            $photoUrl = "https://qabul.sarbon.university/frontend/web/images/new_bino.jpg";
            return $telegram->sendPhoto([
                'chat_id' => $gram->telegram_id,
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
        } catch (\Exception $e) {
            return $telegram->sendMessage([
                'chat_id' => self::CHAT_ID,
                'text' => ['Ik main :( '.$e->getMessage()],
            ]);
        }
    }

    public static function setBotCommands($botToken, $lang_id)
    {
        $url = "https://api.telegram.org/bot{$botToken}/setMyCommands";

        $commands = [
            ['command' => 'home', 'description' => '🏠 Bosh sahifa'],
            ['command' => 'signUp', 'description' => self::getT("a3", $lang_id)],
            ['command' => 'university', 'description' => self::getT("a1", $lang_id)],
            ['command' => 'directions', 'description' => self::getT("a2", $lang_id)],
            ['command' => 'langUpdate', 'description' => self::getT("a4", $lang_id)],
        ];

        $postData = json_encode([
            'commands' => $commands
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
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
                "uz" => "🏫 Universitet haqida",
                "ru" => "",
                "en" => "",
            ],
            "a2" => [
                "uz" => "🪧 Mavjud yo'nalishlar",
                "ru" => "",
                "en" => "",
            ],
            "a3" => [
                "uz" => "👨‍🎓 Ro'yhatdan o'tish",
                "ru" => "",
                "en" => "",
            ],
            "a4" => [
                "uz" => "🔄 Bot tilini o'zgartirish",
                "ru" => "",
                "en" => "",
            ],
            "a5" => [
                "uz" => "🏠 Bosh sahifa",
                "ru" => "",
                "en" => "",
            ],
            "a6" => [
                "uz" => "❌ Arizani faqat UZB telefon raqamlari orqali qoldirishingiz mumkin. \n\n<i>Aloqa uchun: ".self::PHONE."</i>",
                "ru" => "",
                "en" => "",
            ],
            "a7" => [
                "uz" => "☎️",
                "ru" => "",
                "en" => "",
            ],
            "a8" => [
                "uz" => "❌ Ma'lumotni noto'g'ri yubordingiz.\n\n<i>Aloqa uchun: " . self::PHONE . "</i>",
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
