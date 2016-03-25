<?php

/* @var $this yii\web\View */
/* @var $model \app\models\LinkForm */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'Сокращатель ссылок';

if (!$model->isEmpty()) {
    $model->short_link = Url::base(true).'/'.$model->short_link;
    $model->stat_link = Url::to(['stat', 'statLink' => $model->stat_link],true);
}

?>
<div class="site-index">
    <div class="col-sm-offset-2 col-sm-8">

        <?php Pjax::begin() ?>
            <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>
            <?= $form->field($model, 'link') ?>
            <div class="form-group">
                <?= Html::submitButton('Сгенерировать', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>
            <?php if (!$model->isEmpty()) { ?>
                <?= $form->field($model, 'short_link')->textInput(['readonly' => true]) ?>
                <?= $form->field($model, 'stat_link')->textInput(['readonly' => true]) ?>
            <?php } ?>
            <?php ActiveForm::end(); ?>
        <?php Pjax::end() ?>

    </div>
</div>
