<?php

namespace plathir\widgets\backend\controllers;

use yii;
use yii\web\Controller;
use \plathir\widgets\backend\models\Layouts;
use plathir\widgets\backend\models\search\Layouts_s;
use yii\filters\VerbFilter;
use plathir\widgets\backend\models\Widgets;
use plathir\widgets\common\helpers\PositionHelper;
use plathir\widgets\backend\models\Positions;

/**
 * @property \plathir\widgets\backend\Module $module
 *
 */
class LayoutsController extends Controller {

    public $permissionName = 'SystemWidgets';

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

    public function actionIndex() {
        if (\yii::$app->user->can($this->permissionName)) {
            \yii\helpers\Url::remember();
            $searchModel = new Layouts_s();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('widgets', 'No Permission to View Layouts ' . $this->permissionName));
        }
    }

    public function actionCreate() {
        if (\yii::$app->user->can($this->permissionName)) {
            $model = new Layouts();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('widgets', 'Layout : {tech_name} created', ['tech_name' => $model->tech_name]));
                return $this->redirect(['index']);
            } else {
                $positions = Positions::findAll(['publish' => 1]);
                return $this->render('create', [
                            'model' => $model,
                            'positions' => $positions
                ]);
            }
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('widgets', 'No Permission to Create Layout ' . $this->permissionName));
        }
    }

    public function actionUpdate($tech_name) {
        if (\yii::$app->user->can($this->permissionName)) {
            $model = $this->findModel($tech_name);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('widgets', 'Layout : {tech_name} updated', ['id' => $tech_name]));
                return $this->redirect(['index']);
            } else {

                $positions = Positions::findAll(['publish' => 1]);
                return $this->render('update', [
                            'model' => $model,
                            'positions' => $positions
                ]);
            }
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('widgets', 'No Permission to Update Layout ' . $this->permissionName));
        }
    }

    public function actionView($tech_name) {
        if (\yii::$app->user->can($this->permissionName)) {
            \yii\helpers\Url::remember();
            $model = $this->findModel($tech_name);

            return $this->render('view', [
                        'model' => $model
            ]);
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('widgets', 'No Permission to View Layout ' . $this->permissionName));
        }
    }

    public function actionDelete($tech_name) {
        if (\yii::$app->user->can($this->permissionName)) {
            if ($this->findModel($tech_name)->delete()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('widgets', 'Layout : {tech_name} deleted', ['tech_name' => $tech_name]));
            }
            return $this->redirect(['index']);
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('widgets', 'No Permission to Delete Layout ' . $this->permissionName));
        }
    }

    protected function findModel($tech_name) {
        if (($model = Layouts::findOne($tech_name)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('widgets', 'The requested page does not exist !'));
        }
    }

}
