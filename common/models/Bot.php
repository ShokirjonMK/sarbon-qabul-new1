<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\httpclient\Client;

/**
 * Bot model
 */
class Bot extends Model
{
    const CHAT_ID = 1841508935;
    const PHONE = '+998 94 505 52 50';

    const IMG = '/frontend/web/images/bot_univer.jpg';

    const CONS = 0;

    public static function telegram($telegram)
    {
        $telegram_id = $telegram->input->message->chat->id;
        $username = $telegram->input->message->chat->username;
        $gram = Telegram::findOne([
            'telegram_id' => $telegram_id,
            'is_deleted' => 0
        ]);
        if (!$gram) {
            $gram = new Telegram();
            $gram->telegram_id = $telegram_id;
            $gram->username = $username;
            $gram->lang_id = 1;
            $gram->save(false);

            self::sendPhone($telegram, $gram);
        } else {
            $type = $gram->type;
            $lang_id = $gram->lang_id;
            $text = $telegram->input->message->text;
            $gram->username = $username;
            $gram->update(false);

            if ($type != 0) {
                if ($text == '/home' || $text == self::getT("a5", $lang_id)) {
                    self::sendHome($telegram, $lang_id, $gram);
                    return true;
                } elseif ($text == '/signup' || $text == self::getT("a3", $lang_id)) {
                    self::signUp($telegram, $lang_id, $gram);
                    return true;
                } elseif ($text == '/university' || $text == self::getT("a1", $lang_id)) {
                    self::sendUniversity($telegram, $lang_id, $gram);
                    return true;
                } elseif ($text == '/directions' || $text == self::getT("a2", $lang_id)) {
                    self::sendDirections($telegram, $lang_id, $gram);
                    return true;
                } elseif ($text == '/langupdate' || $text == self::getT("a4", $lang_id)) {
                    self::sendLang($telegram, $lang_id, $gram);
                    return true;
                }
            }

            switch ($type) {
                case 0:
                    self::main($telegram, $lang_id, $gram);
                    break;
                case 10:
                    self::signUp($telegram, $lang_id, $gram);
                    break;
                case 4:
                    // Bot tilini ozgartirish
                    self::langUpdate($telegram, $lang_id, $gram);
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
                    $raw = preg_replace('/\D/', '', $gram->phone);

                    $formatted = '+998 (' . substr($raw, 3, 2) . ') ' .
                        substr($raw, 5, 3) . '-' .
                        substr($raw, 8, 2) . '-' .
                        substr($raw, 10, 2);

                    $gram->phone = $formatted;
                    $gram->type = 1;
                    $gram->save(false);

                    return $telegram->sendMessage([
                        'chat_id' => $gram->telegram_id,
                        'text' => self::getT("a20", $lang_id),
                        'parse_mode' => 'HTML',
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

    public static function sendHome($telegram, $lang_id, $gram)
    {
        try {
            $gram->type = 1;
            $gram->save(false);

            return $telegram->sendMessage([
                'chat_id' => $gram->telegram_id,
                'text' => self::getT("a20", $lang_id),
                'parse_mode' => 'HTML',
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
        } catch (\Exception $e) {
            return $telegram->sendMessage([
                'chat_id' => self::CHAT_ID,
                'text' => ['Ik main :( '.$e->getMessage()],
            ]);
        }
    }

    public static function langUpdate($telegram, $lang_id, $gram)
    {
        try {
            $text = $telegram->input->message->text;

            if ($text == self::getT("a9", $lang_id)) {
                // O'zbek tili
                $gram->lang_id = 1;
                $gram->type = 1;
                $gram->save(false);
            } elseif ($text == self::getT("a10", $lang_id)) {
                // Ingliz tili
                $gram->type = 1;
                $gram->lang_id = 2;
                $gram->save(false);
            } elseif ($text == self::getT("a11", $lang_id)) {
                // Rus tili
                $gram->type = 1;
                $gram->lang_id = 3;
                $gram->save(false);
            } elseif ($text == self::getT("a12", $lang_id)) {
                $gram->type = 1;
                $gram->save(false);
            } else {
                return $telegram->sendMessage([
                    'chat_id' => $gram->telegram_id,
                    'text' => self::getT("a8", $lang_id),
                    'parse_mode' => 'HTML',
                ]);
            }

            return $telegram->sendMessage([
                'chat_id' => $gram->telegram_id,
                'text' => self::getT("a20", $lang_id),
                'parse_mode' => 'HTML',
                'reply_markup' => json_encode([
                    'keyboard' => [
                        [
                            ['text' => self::getT("a1", $gram->lang_id)],
                            ['text' => self::getT("a2", $gram->lang_id)],
                        ],
                        [
                            ['text' => self::getT("a4", $gram->lang_id)],
                            ['text' => self::getT("a3", $gram->lang_id)],
                        ]
                    ],
                    'resize_keyboard' => true,
                ])
            ]);
        } catch (\Exception $e) {
            return $telegram->sendMessage([
                'chat_id' => self::CHAT_ID,
                'text' => ['Ik main :( '.$e->getMessage()],
            ]);
        }
    }

    public static function sendLang($telegram, $lang_id, $gram)
    {
        try {
            $gram->type = 4;
            $gram->save(false);

            return $telegram->sendMessage([
                'chat_id' => $gram->telegram_id,
                'text' => self::getT("a13", $lang_id),
                'reply_markup' => json_encode([
                    'keyboard' => [
                        [
                            ['text' => self::getT("a9", $lang_id)],
                            ['text' => self::getT("a10", $lang_id)],
                        ],
                        [
                            ['text' => self::getT("a11", $lang_id)],
                            ['text' => self::getT("a12", $lang_id)],
                        ]
                    ],
                    'resize_keyboard' => true,
                ])
            ]);
        } catch (\Exception $e) {
            return $telegram->sendMessage([
                'chat_id' => self::CHAT_ID,
                'text' => ['Ik main :( '.$e->getMessage()],
            ]);
        }
    }

    public static function sendDirections($telegram, $lang_id, $gram)
    {
        try {
            $gram->type = 1;
            $gram->save(false);

            $text = "Yo'nalishlar";

            return $telegram->sendMessage([
                'chat_id' => $gram->telegram_id,
                'text' => $text,
                'reply_markup' => json_encode([
                    'keyboard' => [
                        [
                            ['text' => self::getT("a9", $lang_id)],
                            ['text' => self::getT("a10", $lang_id)],
                        ],
                        [
                            ['text' => self::getT("a11", $lang_id)],
                            ['text' => self::getT("a12", $lang_id)],
                        ]
                    ],
                    'resize_keyboard' => true,
                ])
            ]);
        } catch (\Exception $e) {
            return $telegram->sendMessage([
                'chat_id' => self::CHAT_ID,
                'text' => ['Ik main :( '.$e->getMessage()],
            ]);
        }
    }

    public static function sendUniversity($telegram, $lang_id, $gram)
    {
        try {
            $gram->type = 1;
            $gram->save(false);

            $text = "Universitet";

            return $telegram->sendMessage([
                'chat_id' => $gram->telegram_id,
                'text' => $text,
                'reply_markup' => json_encode([
                    'keyboard' => [
                        [
                            ['text' => self::getT("a9", $lang_id)],
                            ['text' => self::getT("a10", $lang_id)],
                        ],
                        [
                            ['text' => self::getT("a11", $lang_id)],
                            ['text' => self::getT("a12", $lang_id)],
                        ]
                    ],
                    'resize_keyboard' => true,
                ])
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

    public static function signUp($telegram, $lang_id, $gram)
    {
        try {
            $text = $telegram->input->message->text;
            $gram->type = 10;
            $gram->update(false);
            $step = $gram->step;

            if ($step == 0) {
                self::step0($telegram, $lang_id, $gram, $text);
            } elseif ($step == 1) {
                self::step1($telegram, $lang_id, $gram, $text);
            }
        } catch (\Exception $e) {
            return $telegram->sendMessage([
                'chat_id' => self::CHAT_ID,
                'text' => ['Ik main :( ' . $e->getMessage()],
            ]);
        }
    }


    public static function step0($telegram, $lang_id, $gram, $text)
    {
        if ($text === '/signup' || $text === self::getT("a3", $lang_id)) {
            return $telegram->sendMessage([
                'chat_id' => $gram->telegram_id,
                'text' => self::getT("a16", $lang_id), // Pasport seriya va raqamini kiriting
                'parse_mode' => 'HTML',
                'reply_markup' => json_encode([
                    'remove_keyboard' => true
                ])
            ]);
        }

        $backText = self::getT("a12", $lang_id); // "Orqaga" tugmasi matni

        // Agar foydalanuvchi "Orqaga" tugmasini bosgan bo‘lsa
        if ($text === $backText) {
            $gram->step = 0;
            $gram->save(false);
            return $telegram->sendMessage([
                'chat_id' => $gram->telegram_id,
                'text' => self::getT("a16", $lang_id), // Pasport seriya va raqamini kiriting
                'parse_mode' => 'HTML',
                'reply_markup' => json_encode([
                    'remove_keyboard' => true
                ])
            ]);
        }

        // Agar foydalanuvchi pasport seriya va raqamini to‘g‘ri kiritgan bo‘lsa
        if (self::seria($text)) {
            $gram->passport_serial = substr($text, 0, 2);
            $gram->passport_number = substr($text, 2, 9);
            $gram->step = 1;
            $gram->save(false);

            return $telegram->sendMessage([
                'chat_id' => $gram->telegram_id,
                'text' => self::getT("a15", $lang_id), // Tug‘ilgan sanani kiriting
                'parse_mode' => 'HTML',
                'reply_markup' => json_encode([
                    'keyboard' => [
                        [
                            ['text' => $backText],
                        ],
                    ],
                    'resize_keyboard' => true,
                ])
            ]);
        }

        // Noto‘g‘ri pasport raqami kiritilgan bo‘lsa
        return $telegram->sendMessage([
            'chat_id' => $gram->telegram_id,
            'text' => self::getT("a17", $lang_id), // Xatolik: noto‘g‘ri format
            'parse_mode' => 'HTML',
            'reply_markup' => json_encode([
                'remove_keyboard' => true
            ])
        ]);
    }

    public static function step1($telegram, $lang_id, $gram, $text)
    {
        $i = 1;
        $backText = self::getT("a12", $lang_id); // "Orqaga" tugmasi matni

        if ($text === '/signup' || $text === self::getT("a3", $lang_id)) {
            return $telegram->sendMessage([
                'chat_id' => $gram->telegram_id,
                'text' => self::getT("a15", $lang_id), // Tug‘ilgan sanani kiriting
                'parse_mode' => 'HTML',
                'reply_markup' => json_encode([
                    'keyboard' => [
                        [
                            ['text' => $backText],
                        ],
                    ],
                    'resize_keyboard' => true,
                ])
            ]);
        }

        // Agar foydalanuvchi "Orqaga" tugmasini bosgan bo‘lsa
        if ($text === $backText) {
            $gram->step = ($i - 1);
            $gram->save(false);
            return $telegram->sendMessage([
                'chat_id' => $gram->telegram_id,
                'text' => self::getT("a16", $lang_id), // Pasport seriya va raqamini kiriting
                'parse_mode' => 'HTML',
                'reply_markup' => json_encode([
                    'remove_keyboard' => true
                ])
            ]);
        }

        // Agar foydalanuvchi pasport seriya va raqamini to‘g‘ri kiritgan bo‘lsa
        if (self::date($text)) {
            $gram->birthday = date("Y-m-d", strtotime($text));
            $gram->step = ($i + 1);

            $passport = self::passport($gram);
            if ($passport['is_ok']) {
                $gram = $passport['gram'];
                $gram->save(false);
            } else {
                $telegram->sendMessage([
                    'chat_id' => $gram->telegram_id,
                    'text' => self::getT("a19", $lang_id), // Pasport ma'lumoti yuklashda xatolik
                    'parse_mode' => 'HTML',
                    'reply_markup' => json_encode([
                        'remove_keyboard' => true
                    ])
                ]);
                return $telegram->sendMessage([
                    'chat_id' => $gram->telegram_id,
                    'text' => self::getT("a15", $lang_id), // Tug‘ilgan sanani kiriting
                    'parse_mode' => 'HTML',
                    'reply_markup' => json_encode([
                        'keyboard' => [
                            [
                                ['text' => $backText],
                            ],
                        ],
                        'resize_keyboard' => true,
                    ])
                ]);
            }
        }

        // Noto‘g‘ri sana kiritilgan bo‘lsa
        return $telegram->sendMessage([
            'chat_id' => $gram->telegram_id,
            'text' => self::getT("a18", $lang_id), // Xatolik: noto‘g‘ri format
            'parse_mode' => 'HTML',
            'reply_markup' => json_encode([
                'remove_keyboard' => true
            ])
        ]);
    }


    public static function step10($telegram, $lang_id, $text, $user, $student)
    {
        $query = Branch::find()
            ->where(['status' => 1, 'is_deleted' => 0]);

        $query->andWhere(['not in', 'cons_id', [null]]);

        if ($lang_id == 1) {
            $query->andWhere(['name_uz' => $text]);
        } elseif ($lang_id == 2) {
            $query->andWhere(['name_en' => $text]);
        } elseif ($lang_id == 3) {
            $query->andWhere(['name_ru' => $text]);
        }

        $branch = $query->limit(1)->one();

        if ($branch) {
            $student->branch_id = $branch->id;
            if (self::CONS == 0) {
                $user->cons_id = $branch->cons_id;
            }
            $user->bot_status = 1;
            $student->save(false);
            $user->save(false);


        }
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

    public static function seria($text)
    {
        $pattern = '/^[A-Z]{2}\d{7}$/';
        if (preg_match($pattern, $text)) {
            return true;
        } else {
            return false;
        }
    }

    public static function date($text)
    {
        $format = 'Y-m-d';
        $d = \DateTime::createFromFormat($format, $text);
        return $d && $d->format($format) === $text;
    }

    public static function passport($gram)
    {
        $client = new Client();
        $url = 'https://api.online-mahalla.uz/api/v1/public/tax/passport';
        $params = [
            'series' => $gram->passport_serial,
            'number' => $gram->passport_number,
            'birth_date' => $gram->birthday,
        ];
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl($url)
            ->setData($params)
            ->send();

        if ($response->isOk) {
            $responseData = $response->data;
            $passport = $responseData['data']['info']['data'];
            $gram->first_name = $passport['name'];
            $gram->last_name = $passport['sur_name'];
            $gram->middle_name = $passport['patronymic_name'];
            $gram->passport_pin = (string)$passport['pinfl'];

            $gram->gender = 1;
            return ['is_ok' => true, 'gram' => $gram];
        }
        return ['is_ok' => false];
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

            "a9" => [
                "uz" => "🇺🇿 O'zbek tili",
                "ru" => "",
                "en" => "",
            ],
            "a10" => [
                "uz" => "🇷🇺 Rus tili",
                "ru" => "",
                "en" => "",
            ],
            "a11" => [
                "uz" => "🏴󠁧󠁢󠁥󠁮󠁧󠁿 Ingliz tili",
                "ru" => "",
                "en" => "",
            ],
            "a12" => [
                "uz" => "🔙 Orqaga",
                "ru" => "",
                "en" => "",
            ],

            "a13" => [
                "uz" => "🤖 Bot tilini tanlang! \n\n Shunda bot siz tanlagan tilda javob berishni boshlaydi 😊",
                "ru" => "",
                "en" => "",
            ],
            "a14" => [
                "uz" => "❌:( Raqamingizni ro'yhatdan o'tkazib bo'lmadi.\n\n<i>Aloqa uchun: " . self::PHONE . "</i>",
                "ru" => "",
                "en" => "",
            ],
            "a15" => [
                "uz" => "📅 Tug'ilgan sanangizni (yil-oy-sana ko'rinishida) yozing.\n\n<i>Masalan: 2001-10-16</i>",
                "ru" => "",
                "en" => "",
            ],
            "a16" => [
                "uz" => "📄 Pasportingiz seriyasi va raqamini yozing.\n\n<i>Masalan: AB1234567</i>",
                "ru" => "",
                "en" => "",
            ],
            "a17" => [
                "uz" => "📄❌ Pasportingiz seriyasi va raqamini namunada ko'rsatilgan formatda yuboring .\n\n<i>Masalan: AB1234567</i>",
                "ru" => "",
                "en" => "",
            ],
            "a18" => [
                "uz" => "📅❌:( Tug'ilgan sanangiz namunada ko'rsatilgandek yuboring.\n\n<i>Masalan: 2001-10-16</i>",
                "ru" => "",
                "en" => "",
            ],
            "a19" => [
                "uz" => "❌:( Pasport ma'lumotini yuklashda xatolik sodir bo'ldi .\n\n<i>Aloqa uchun: " . self::PHONE . "</i>",
                "ru" => "",
                "en" => "",
            ],
            "a20" => [
                "uz" => "😊 Bosh sahifaga xush kelibsiz.",
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
