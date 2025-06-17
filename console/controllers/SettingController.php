<?php

namespace console\controllers;

use backend\models\UserUpdate;
use common\models\AuthAssignment;
use common\models\Direction;
use common\models\DirectionSubject;
use common\models\Exam;
use common\models\ExamStudentQuestions;
use common\models\ExamSubject;
use common\models\Message;
use common\models\Options;
use common\models\Questions;
use common\models\SendMessage;
use common\models\Student;
use common\models\StudentDtm;
use common\models\StudentOferta;
use common\models\StudentPerevot;
use common\models\User;
use frontend\models\Test;
use Yii;
use yii\console\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\httpclient\Client;
use yii\web\Request;

class SettingController extends Controller
{
    public function actionIk5()
    {
        $transaction = Yii::$app->db->beginTransaction();

        $startTime = strtotime('2025-06-14 00:00:00');
        $endTime = strtotime('2025-06-14 23:59:59');

        $exams = Exam::find()
            ->where(['is_deleted' => 0])
            ->andWhere(['between', 'start_time', $startTime, $endTime])
            ->andWhere(['>', 'status', 1])
            ->andWhere(['in', 'student_id',
                Student::find()
                    ->select('id')
                    ->where(['exam_type' => 1])
            ])
            ->all();

        dd(count($exams));

//        foreach ($exams as $exam) {
//            $questions = ExamStudentQuestions::find()
//                ->where([
//                    'exam_id' => $exam->id,
//                ])
//                ->all();
//            foreach ($questions as $question) {
//                if ($question->option_id != null) {
//                    $option = Options::findOne($question->option_id);
//                    $question->is_correct = $option ? $option->is_correct : 0;
//                    $question->save(false);
//                }
//            }
//
//            Test::finishExam($exam);
//        }
//
//        $transaction->commit();
    }
}
