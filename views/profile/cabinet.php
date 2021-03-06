<?php

    use yii\helpers\Html;
    use yii\widgets\DetailView;
    use app\models\User;

    /* @var $this yii\web\View */
    /* @var $model app\models\User */

    $this->title = $model->getFullName();
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'email:email',
            [
                'attribute' => 'Статус',
                'value' => function (User $model) {
                    return $model->getOnlineIcon() . ' ' . $model->getOnlineLabel();
                },
                'format' => 'html'
            ],
        ],
    ]) ?>
    <p>
        <?= Html::a($model->isOnline() ? 'Стать оффлайн' : 'Стать онлайн', ['toggle-status'], [
            'class' => $model->isOnline() ? 'btn btn-danger' : 'btn btn-success',
            'data' => [
                'confirm' => "Изменить онлайн статус?",
                'method' => 'post',
            ],
        ]) ?>
    </p>
</div>
