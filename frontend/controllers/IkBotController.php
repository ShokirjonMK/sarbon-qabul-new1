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

        $message = "Sarbon universitetida qabul boshlandi<br><br>";
        $message .= "2025-2026-o‘quv yillari uchun <b>kunduzgi, kechki va masofaviy ta'lim shakllariga</b> Sarbon universitetida qabul boshlanganini e'lon qilamiz.<br><br>";
        $message .= "Biz bilan yetakchilar safida bo'!<br><br>";
        $message .= "<b>Mavjud yo‘nalishlarimiz:</b><br>";

        $message .= "<blockquote>";
        $message .= "• Yurisdprudentsiya<br>";
        $message .= "• Davlat va jamiyat boshqaruvi<br>";
        $message .= "• Kosmetologiya<br>";
        $message .= "• Buxgalteriya hisobi<br>";
        $message .= "• Iqtisodiyot<br>";
        $message .= "• Bank ishi<br>";
        $message .= "• Moliya va moliyaviy texnologiyalar<br>";
        $message .= "• Jahon iqtisodiyoti va xalqaro iqtisodiy munosabatlar<br>";
        $message .= "• Biznesni boshqarish<br>";
        $message .= "• Logistika<br>";
        $message .= "• Marketing<br>";
        $message .= "• Xalqaro munosabatlar<br>";
        $message .= "• Turizm va mehmondo‘stlik<br>";
        $message .= "• Psixologiya<br>";
        $message .= "• Tarix<br>";
        $message .= "• Milliy g‘oya, ma’naviyat asoslari va huquq ta’limi<br>";
        $message .= "• Filologiya va tillarni o‘qitish (ingliz tili, rus tili, xitoy tili, o‘zbek tili, turk tili)<br>";
        $message .= "• Axborot tizimlari va texnologiyalari<br>";
        $message .= "• Axborot xavfsizligi<br>";
        $message .= "• Kompyuter injiniringi<br>";
        $message .= "• Mexatronika va robototexnika<br>";
        $message .= "• Dizayn<br>";
        $message .= "• Arxitektura<br>";
        $message .= "• Qurilish muhandisligi (Neft va gazni qayta ishlash sanoati obyektlari faoliyati turi bo‘yicha)<br>";
        $message .= "• Kommunal infratuzilmani tashkil etish va boshqarish<br>";
        $message .= "</blockquote>";

// Xabar yuborish
        return $telegram->sendMessage([
            'chat_id' => $telegram_id,
            'text' => $message,
            'parse_mode' => 'HTML'
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
