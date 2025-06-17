<?php

namespace console\controllers;

use backend\models\UserUpdate;
use common\models\AuthAssignment;
use common\models\CrmPush;
use common\models\Direction;
use common\models\DirectionBall;
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
    public function actionIk7()
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
//            $time = time();
//
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
//            if ($time < $exam->finish_time) {
//                $exam->finish_time = $time;
//            }
//
//            $model = self::finish($exam);
//
//            $student = $model->student;
//            $user = $student->user;
//            $amo = CrmPush::processType(6, $student, $user);
//            if (!$amo['is_ok']) {
//                $transaction->rollBack();
//                dd($amo['errors']);
//            }
//        }
//
//        $transaction->commit();
    }


    public static function finish($model)
    {
        $model->status = 3;
        $examSubjects = $model->examSubjects;
        $direction = $model->eduDirection;
        $student = $model->student;

        $model->ball = 0;
        foreach ($examSubjects as $examSubject) {
            $directionSubject = $examSubject->directionSubject;
            $one_ball = $directionSubject->ball;
            if ($examSubject->file_status == 2) {
                $examSubject->ball = $directionSubject->count * $one_ball;
                ExamStudentQuestions::updateAll(['is_correct' => 1, 'updated_at' => time()], ['exam_subject_id' => $examSubject->id, 'status' => 1, 'is_deleted' => 0]);
            } else {
                $questions = ExamStudentQuestions::find()
                    ->where([
                        'exam_subject_id' => $examSubject->id,
                        'is_correct' => 1,
                        'status' => 1,
                        'is_deleted' => 0
                    ])->count();
                $examSubject->ball = ($questions * $one_ball);
            }
            $model->ball = $model->ball + $examSubject->ball;
            $examSubject->save(false);
        }


        $sh = false;
        $conBalls = DirectionBall::find()
            ->where([
                'edu_direction_id' => $direction->id,
                'status' => 1,
                'is_deleted' => 0
            ])
            ->all();
        foreach ($conBalls as $conBall) {
            if ($conBall->start_ball <= $model->ball && $conBall->end_ball >= $model->ball) {
                $sh = true;
                if ($conBall->type <= 0) {
                    $model->status = 4;
                    $model->contract_price = null;
                    $model->confirm_date = null;
                } else {
                    if ($model->ball >= 30 && $model->ball <= 75.5) {
                        $model->ball = rand(76, 80);
                    }
                    $model->contract_price = $direction->price * $conBall->type;
                    $model->confirm_date = time();
                }
            }
        }

        if (!$sh) {
            $model->status = 4;
            $model->contract_price = null;
            $model->confirm_date = null;
        }

        $student->is_down = 0;
        $student->update(false);

        $model->save(false);
        return $model;
    }

}
