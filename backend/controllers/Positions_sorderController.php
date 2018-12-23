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
    
        public function __construct($id, $module) {
        parent::__construct($id, $module);
                $this->layout = "main";
    }
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

    public function actionUpdate($tech_name) {
        $model = $this->findModel($tech_name);
        if ($model != null) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('widgets', 'Position : {position_tech_name} updated !', ['position_tech_name' => $model->position_tech_name]));
                return $this->goBack();
            } else {
                return $this->render('update', [
                            'model' => $model
                ]);
            }
        } else {
            Yii::$app->getSession()->setFlash('danger', Yii::t('widgets', 'No sort order found for Position : {tech_name} ', ['tech_name' => $tech_name]));
            return $this->goBack();
        }
    }

    protected function findModel($tech_name) {
        if (($model = \plathir\widgets\backend\models\PositionsSortOrder::findOne($tech_name)) !== null) {
            return $model;
        } else {
            Yii::$app->getSession()->setFlash('danger', Yii::t('widgets', 'Not found widgets for Position : {position_tech_name} ', ['position_tech_name' => $tech_name]));
//            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
