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

        try {

            $result = Bot::telegram($telegram);
            if ($result['is_ok']) {
                return $result['telegram'];
            }

        } catch (\Exception $e) {
            return $telegram->sendMessage([
                'chat_id' => 1841508935,
                'text' => $e->getMessage(),
            ]);
        } catch (\Throwable $t) {
            return $telegram->sendMessage([
                'chat_id' => 1841508935,
                'text' => $t->getMessage(), " at ", $t->getFile(), ":", $t->getLine(),
            ]);
        }
    }

}
