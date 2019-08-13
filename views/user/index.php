<?php

    use yii\helpers\Html;
    use yii\grid\GridView;
    use app\models\User;

    /* @var $this yii\web\View */
    /* @var $searchModel app\models\SearchUser */
    /* @var $dataProvider yii\data\ActiveDataProvider */

    $this->title = 'Пользователи';
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'username',
                'visible' => !Yii::$app->user->isGuest
            ],
            'name',
            'last_name',
            [
                'value' => function (User $model) {
                    return $model->getOnlineIcon() . ' ' . $model->getOnlineLabel();
                },
                'filter' => $searchModel->getOnlineLabelList(),
                'attribute' => 'is_online',
                'format' => 'html',
                'visible' => !Yii::$app->user->isGuest,
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'Подробнее',
                'headerOptions' => ['width' => '40'],
                'template' => '{view}',
                'visible' => !Yii::$app->user->isGuest,
            ],
        ],
    ]); ?>


</div>
