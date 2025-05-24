<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "telegram".
 *
 * @property int $id
 * @property string|null $telegram_id
 * @property string|null $phone
 * @property string|null $user_id
 * @property int|null $step
 * @property int|null $type
 * @property int|null $lang_id
 * @property string|null $birthday
 * @property string|null $passport_number
 * @property string|null $passport_serial
 * @property string|null $passport_pin
 * @property int|null $edu_type_id
 * @property int|null $edu_form_id
 * @property int|null $edu_direction_id
 * @property int|null $direction_course_id
 * @property int|null $exam_type
 * @property int|null $branch_id
 * @property int|null $exam_date_id
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $is_deleted
 */
class Telegram extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'telegram';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['telegram_id', 'phone','type', 'user_id', 'birthday', 'passport_number', 'passport_serial', 'passport_pin', 'edu_type_id', 'edu_form_id', 'edu_direction_id', 'direction_course_id', 'branch_id', 'exam_date_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['is_deleted', 'type'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 1],
            [['step', 'lang_id', 'edu_type_id', 'edu_form_id', 'edu_direction_id', 'direction_course_id', 'exam_type', 'branch_id', 'exam_date_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['telegram_id', 'phone', 'user_id', 'birthday', 'passport_number', 'passport_serial', 'passport_pin'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'telegram_id' => Yii::t('app', 'Telegram ID'),
            'phone' => Yii::t('app', 'Phone'),
            'user_id' => Yii::t('app', 'User ID'),
            'step' => Yii::t('app', 'Step'),
            'lang_id' => Yii::t('app', 'Lang ID'),
            'birthday' => Yii::t('app', 'Birthday'),
            'passport_number' => Yii::t('app', 'Passport Number'),
            'passport_serial' => Yii::t('app', 'Passport Serial'),
            'passport_pin' => Yii::t('app', 'Passport Pin'),
            'edu_type_id' => Yii::t('app', 'Edu Type ID'),
            'edu_form_id' => Yii::t('app', 'Edu Form ID'),
            'edu_direction_id' => Yii::t('app', 'Edu Direction ID'),
            'direction_course_id' => Yii::t('app', 'Direction Course ID'),
            'exam_type' => Yii::t('app', 'Exam Type'),
            'branch_id' => Yii::t('app', 'Branch ID'),
            'exam_date_id' => Yii::t('app', 'Exam Date ID'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

}
