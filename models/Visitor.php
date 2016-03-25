<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%visitor}}".
 *
 * @property string $id
 * @property string $date
 * @property string $region
 * @property string $browser
 * @property string $os
 */
class Visitor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%visitor}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['region', 'browser', 'os'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ip' => 'IP',
            'date' => 'Дата',
            'region' => 'Регион',
            'browser' => 'Браузер',
            'os' => 'ОС',
        ];
    }
}
