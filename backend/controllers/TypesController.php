<?php

namespace plathir\widgets\backend\controllers;

use yii;
use yii\web\Controller;
use \plathir\widgets\backend\models\WidgetsTypes;
use plathir\widgets\backend\models\search\WidgetsTypes_s;
use yii\filters\VerbFilter;

/**
 * @property \plathir\widgets\backend\Module $module
 *
 */
class TypesController extends Controller {

    public function init() {
        parent::init();
        #add your logic: read the cookie and then set the language
        //  \Yii::$app->language = 'en'; 
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

    public function actionIndex() {
        $searchModel = new WidgetsTypes_s();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate() {
        $model = new WidgetsTypes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('widgets', 'Type : {type} created', ['type' => $model->tech_name]));
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                        'model' => $model
            ]);
        }
    }

    public function actionUpdate($tech_name) {
        $model = $this->findModel($tech_name);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('widgets', 'Type : {type} updated', ['type' => $model->tech_name]));
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                        'model' => $model
            ]);
        }
    }

    public function actionView($tech_name) {
        $model = $this->findModel($tech_name);

        return $this->render('view', [
                    'model' => $model
        ]);
    }

    public function actionDelete($tech_name) {
        if ($this->findModel($tech_name)->delete()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('widgets', 'Type : {type} deleted', ['type' => $tech_name]));
        }
        return $this->redirect(['index']);
    }

    protected function findModel($tech_name) {
        if (($model = WidgetsTypes::findOne($tech_name)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('widgets', 'The requested page does not exist.'));
        }
    }

}
