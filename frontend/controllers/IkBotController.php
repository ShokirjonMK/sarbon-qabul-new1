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

        $message = "📢 *Sarbon universitetida qabul boshlandi*\n";
        $message .= "```\n";
        $message .= "| 2025-2026-o‘quv yillari uchun:                |\n";
        $message .= "|  Kunduzgi, kechki va masofaviy taʼlim!       |\n";
        $message .= "|                                              |\n";
        $message .= "| Mavjud yo‘nalishlar:                         |\n";
        $message .= "| > Yurisdprudentsiya                          |\n";
        $message .= "| > Davlat va jamiyat boshqaruvi               |\n";
        $message .= "| > Kosmetologiya                              |\n";
        $message .= "| > Buxgalteriya hisobi                        |\n";
        $message .= "| > Iqtisodiyot                                |\n";
        $message .= "| > Bank ishi                                  |\n";
        $message .= "| > Moliya va moliyaviy texnologiyalar         |\n";
        $message .= "| > Jahon iqtisodiyoti va XIM                  |\n";
        $message .= "| > Biznesni boshqarish                        |\n";
        $message .= "| > Logistika                                  |\n";
        $message .= "| > Marketing                                  |\n";
        $message .= "| > Xalqaro munosabatlar                       |\n";
        $message .= "| > Turizm va mehmondo‘stlik                   |\n";
        $message .= "| > Psixologiya                                |\n";
        $message .= "| > Tarix                                      |\n";
        $message .= "| > Milliy gʻoya va maʼnaviyat asoslari        |\n";
        $message .= "| > Filologiya (EN, RU, CN, UZ, TR)            |\n";
        $message .= "| > Axborot tizimlari                          |\n";
        $message .= "| > Axborot xavfsizligi                        |\n";
        $message .= "| > Kompyuter injiniringi                      |\n";
        $message .= "| > Mexatronika va robototexnika               |\n";
        $message .= "| > Dizayn                                     |\n";
        $message .= "| > Arxitektura                                |\n";
        $message .= "| > Qurilish muhandisligi                      |\n";
        $message .= "| > Kommunal infratuzilmani boshqarish         |\n";
        $message .= "```\n";
        $message .= "_Biz bilan yetakchilar safida bo‘l!_";

        return $telegram->sendMessage([
            'chat_id' => $telegram_id,
            'text' => $message,
            'parse_mode' => 'Markdown'
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
