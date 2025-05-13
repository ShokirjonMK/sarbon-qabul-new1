<?php

namespace frontend\controllers;

use common\models\Bot;
use yii\web\Controller;
use Yii;


/**
 * Ik Bot controller
 */
class IkBotController extends Controller
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionCons()
    {
        // Xamkor yozib ketiladi, eslab qolish uchun;

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $telegram = Yii::$app->telegram;
        $text = $telegram->input->message->text;
        $username = $telegram->input->message->chat->username;
        $telegram_id = $telegram->input->message->chat->id;

        // Xabar matni
        $message = "Sarbon universitetida qabul boshlandi\n\n";
        $message .= "2025-2026-o‘quv yillari uchun *kunduzgi, kechki va masofaviy ta'lim shakllariga* Sarbon universitetida qabul boshlanganini e'lon qilamiz.\n\n";
        $message .= "Biz bilan yetakchilar safida bo'! \n\n";
        $message .= "*Mavjud yo‘nalishlarimiz:*\n";

        // Blokni yaratish (Markdownda kod sifatida)
        $message .= "```\n";
        $message .= "• Yurisdruensiya;\n";
        $message .= "• Davlat va jamiyat boshqaruvi;\n";
        $message .= "• Kosmetologiya;\n";
        $message .= "• Buxgalteriya hisobi.\n";
        $message .= "```\n";

        // SendMessage API orqali xabar yuborish
        return $telegram->sendMessage([
            'chat_id' => $telegram_id,
            'text' => $message,
            'parse_mode' => 'Markdown'  // Markdown formatida
        ]);

//        $photoUrl = "https://qabul.sarbon.university/frontend/web/images/new_bino.jpg";
//        return $telegram->sendPhoto([
//            'chat_id' => $telegram_id,
//            'photo' => $photoUrl,
//            'caption' => "🇺🇿 *TASHKENT SARBON UNIVERSITY* haqida rasm\n\nTelefon raqamingizni yuboring",
//            'parse_mode' => 'Markdown',
//            'reply_markup' => json_encode([
//                'keyboard' => [[
//                    [
//                        'text' => "☎️ Telefon raqamni yuborish",
//                        'request_contact' => true
//                    ]
//                ]],
//                'resize_keyboard' => true,
//                'one_time_keyboard' => true,
//            ])
//        ]);
    }

}
