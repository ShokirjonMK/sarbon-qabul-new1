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
        $telegram_id = $telegram->input->message->chat->id;

        $message = "> Sarbon universitetida qabul boshlandi\n";
        $message .= "> 2025-2026-o‘quv yili uchun quyidagi yo‘nalishlarga qabul ochiq:\n";
        $message .= ">\n";
        $message .= "> • Yurisdprudentsiya\n";
        $message .= "> • Kosmetologiya\n";
        $message .= "> • Iqtisodiyot\n";
        $message .= "> • Axborot xavfsizligi\n";
        $message .= "> • Dizayn\n";
        $message .= "> • Qurilish muhandisligi\n";
        $message .= ">\n";
        $message .= "> Hujjat topshirish uchun shoshiling!";

        return $telegram->sendMessage([
            'chat_id' => $telegram_id,
            'text' => $message,
            // parse_mode NI YOZMANG!
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
