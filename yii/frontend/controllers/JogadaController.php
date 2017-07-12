<?php

namespace frontend\controllers;

use Yii;
use common\models\Jogada;
use common\models\JogadaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * JogadaController implements the CRUD actions for Jogada model.
 */
class JogadaController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }



    /**
     * Displays a single Jogada model.
     * @param integer $id
     * @return mixed
     */
    public function actionPlay()
    {
        $searchModel = new JogadaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('play', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Jogada model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionSave()
    {
        if (!Yii::$app->user->isGuest) {

            $pontuacao = Yii::$app->request->post('score');
            $user = Yii::$app->user->identity->id;
            $jogada = new Jogada();
            $jogada->id_user = $user;
            $jogada->pontuacao = $pontuacao;
            $jogada->data_hora = date("F j, Y, g:i a");

            if ($jogada->save()) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    /**
     * Finds the Jogada model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Jogada the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Jogada::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
