<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->getFullName();
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
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

</div>
