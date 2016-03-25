<?php

namespace app\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%sl_link}}".
 *
 * @property string $link
 * @property string $short_link
 * @property string $stat_link
 */
class Link extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%link}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['link', 'required'],
            ['link', 'url'],
            ['link', 'string', 'max' => Yii::$app->params['linkLen']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVisitors()
    {
        return $this->hasMany(Visitor::className(), ['link_id' => 'id']);
    }
}
