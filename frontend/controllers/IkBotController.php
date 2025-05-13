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

        $photoPath = Yii::getAlias('@frontend/web/images/new_bino.jpg');
        $photo = new \CURLFile($photoPath, mime_content_type($photoPath), 'new_bino.jpg');

        return $telegram->sendPhoto([
            'chat_id' => $telegram_id,
            'photo' => $photo,
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

}
