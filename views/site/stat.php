<?php

/* @var $this yii\web\View */
/* @var $model Link */
/* @var $dataProvider ActiveDataProvider */

use app\models\Link;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Статистика переходов по ссылке '.Url::base(true).'/'.$model->short_link;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-stat">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'date',
            'ip',
            'region',
            'browser',
            'os',
        ],
    ]); ?>
</div>
