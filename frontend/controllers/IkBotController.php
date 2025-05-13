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

        $photoUrl = "https://qabul.sarbon.university/frontend/web/images/new_bino.jpg";
        return $telegram->sendPhoto([
            'chat_id' => $telegram_id,
            'photo' => $photoUrl,
            'caption' => "Rasm yetib keldi",
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
