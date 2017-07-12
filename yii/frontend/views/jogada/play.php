<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $searchModel common\models\JogadaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->registerJsFile('tetris/stats.js', [
      'position' => $this::POS_END
]);
$this->registerJsFile('tetris/tetris.js', [
      'position' => $this::POS_END
]);
$this->registerCssFile('tetris/tetris.css');

$this->registerJs("
    $('#saveButton').on('click', function() {
        $.ajax({
            type: 'POST',
            url: '". Url::to(['jogada/save']) ."',
            data: {
                score: score
            },
            success: function(data) {
                $('#ranking').load(' #ranking');
                console.log(data);
            }
        })
    });
");

$this->title = 'Jogar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jogada-play">

    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Html::button('Salvar pontuação', ['class' => 'btn btn-primary', 'id' => 'saveButton'])?></p>

    <div id="tetris" class="childDiv">
        <div id="menu">
            <p id="start"><a href="javascript:play();">Press Space to Play.</a></p>
            <p><canvas id="upcoming"></canvas></p>
            <p>score <span id="score">00000</span></p>
            <p>rows <span id="rows">0</span></p>
        </div>
        <canvas id="canvas">
            Sorry, this example cannot be run because your browser does not support the &lt;canvas&gt; element
        </canvas>
    </div>
    <div id="ranking" class="childDiv">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'id_user',
                //['attribute' => 'id_user', 'value' => $dataProvider->getModels()->username],
                [
                    'label' => 'Usuário',
                    'format'=> 'raw',
                    'value' => function($data) {
                        return $data->getIdUser()->one()->username;
                    }
                ],
                'pontuacao',
                'data_hora',

                //['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
