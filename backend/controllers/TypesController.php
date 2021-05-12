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

    public $permissionName = 'SystemWidgets';

    public function __construct($id, $module) {
        parent::__construct($id, $module);
        $this->layout = "main";
    }

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
        if (\yii::$app->user->can($this->permissionName)) {
            $searchModel = new WidgetsTypes_s();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('widgets', 'No Permission to View Widget types ' . $this->permissionName));
        }
    }

    public function actionCreate() {
        if (\yii::$app->user->can($this->permissionName)) {
            $model = new WidgetsTypes();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('widgets', 'Type : {type} created', ['type' => $model->tech_name]));
                return $this->redirect(['index']);
            } else {
                return $this->render('create', [
                            'model' => $model
                ]);
            }
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('widgets', 'No Permission to Create Widget type ' . $this->permissionName));
        }
    }

    public function actionUpdate($tech_name) {
        if (\yii::$app->user->can($this->permissionName)) {

            $model = $this->findModel($tech_name);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('widgets', 'Type : {type} updated', ['type' => $model->tech_name]));
                return $this->redirect(['index']);
            } else {
                return $this->render('update', [
                            'model' => $model
                ]);
            }
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('widgets', 'No Permission to Update Widget type ' . $this->permissionName));
        }
    }

    public function actionView($tech_name) {
        if (\yii::$app->user->can($this->permissionName)) {
            $model = $this->findModel($tech_name);

            return $this->render('view', [
                        'model' => $model
            ]);
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('widgets', 'No Permission to View Widget type ' . $this->permissionName));
        }
    }

    public function actionDelete($tech_name) {
        if (\yii::$app->user->can($this->permissionName)) {
            if ($this->findModel($tech_name)->delete()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('widgets', 'Type : {type} deleted', ['type' => $tech_name]));
            }
            return $this->redirect(['index']);
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('widgets', 'No Permission to Delete Widget type ' . $this->permissionName));
        }
    }

    protected function findModel($tech_name) {
        if (($model = WidgetsTypes::findOne($tech_name)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('widgets', 'The requested page does not exist.'));
        }
    }

}
