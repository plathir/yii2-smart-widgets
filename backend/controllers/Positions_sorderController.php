<?php

namespace plathir\widgets\backend\controllers;

use yii;
use yii\web\Controller;
use \plathir\widgets\backend\models\Positions;
use plathir\widgets\backend\models\search\PositionsSortOrder_s;
use yii\filters\VerbFilter;

/**
 * @property \plathir\widgets\backend\Module $module
 *
 */
class Positions_sorderController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ]
        ];
    }

//    public function actionIndex() {
//        $searchModel = new PositionsSortOrder_s();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('index', [
//                    'searchModel' => $searchModel,
//                    'dataProvider' => $dataProvider,
//        ]);
//    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if ($model != null) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->getSession()->setFlash('success', 'Position : ' . $model->position_id . ' updated !');
                return $this->goBack();
            } else {
                return $this->render('update', [
                            'model' => $model
                ]);
            }
            
        } else {
           Yii::$app->getSession()->setFlash('danger', 'No sort order found for Position : ' . $id);
           return $this->goBack();
        }
    }

    protected function findModel($id) {
        if (($model = \plathir\widgets\backend\models\PositionsSortOrder::findOne($id)) !== null) {
            return $model;
        } else {
            Yii::$app->getSession()->setFlash('danger', 'Not found widgets for Position : ' . $id);
//            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
