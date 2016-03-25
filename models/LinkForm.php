<?php

namespace app\models;

use Yii;
use yii\base\ErrorException;
use yii\base\Model;
use yii\helpers\Url;

/**
 * ContactForm is the model behind the contact form.
 */
class LinkForm extends Model
{
    public $link;

    public $short_link;
    public $stat_link;

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
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'link' => 'Ваша ссылка',
            'short_link' => 'Короткая ссылка',
            'stat_link' => 'Ссылка для статистики',
        ];
    }

    /**
     * Если ссылка не существует, то генерируем для нее уникальные ссылки.
     * Если существует, то устанавливаем значения из базы.
     * @return void
     */
    public function setLinks()
    {
        if ($this->validate()) {
            $link = Link::findOne(['link' => $this->link]);
            if (is_null($link)) {
                $link = new Link([
                    'link' => $this->link,
                    'short_link' => $this->generateUniqueLink('short_link'),
                    'stat_link' => $this->generateUniqueLink('stat_link')
                ]);
                if ($link->save(false)) {
                    $this->short_link = $link->short_link;
                    $this->stat_link = $link->stat_link;
                } else {
                    $this->addError('link', 'Произошла ошибка. Попробуйте позже');
                    Yii::error('Ошибка сохранения ссылки');
                }
            } else {
                $this->short_link = $link->short_link;
                $this->stat_link = $link->stat_link;
            }
        }
    }

    /**
     * @param string $field
     * @param int $length
     * @return string
     */
    public function generateUniqueLink($field, $length = 5)
    {
        if ($length > Yii::$app->params['shortLinkLen']) {
            throw new \InvalidArgumentException('Длинна должна быть не больше 255');
        }
        $link = Yii::$app->security->generateRandomString($length);
        if (Link::find()->where([$field => $link])->exists()) {
            return $this->generateUniqueLink($field, ++$length);
        } else {
            return $link;
        }
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->link);
    }

}
