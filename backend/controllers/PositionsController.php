<?php

namespace plathir\widgets\backend\controllers;

use yii;
use yii\web\Controller;
use \plathir\widgets\backend\models\Positions;
use plathir\widgets\backend\models\search\Positions_s;
use yii\filters\VerbFilter;
use plathir\widgets\backend\models\Widgets;
use plathir\widgets\common\helpers\PositionHelper;

/**
 * @property \plathir\widgets\backend\Module $module
 *
 */
class PositionsController extends Controller {

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
            $searchModel = new Positions_s();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('widgets', 'No Permission to View Positions '));
        }
    }

    public function actionCreate() {
        if (\yii::$app->user->can($this->permissionName)) {
            $model = new Positions();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('widgets', 'Position : {tech_name} created', ['tech_name' => $model->tech_name]));
                return $this->redirect(['index']);
            } else {
                return $this->render('create', [
                            'model' => $model
                ]);
            }
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('widgets', 'No Permission to Create Position '));
        }
    }

    public function actionUpdate($tech_name) {
        if (\yii::$app->user->can($this->permissionName)) {
            $model = $this->findModel($tech_name);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('widgets', 'Position : {tech_name} updated', ['id' => $tech_name]));
                return $this->redirect(['index']);
            } else {
                return $this->render('update', [
                            'model' => $model
                ]);
            }
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('widgets', 'No Permission to Update Position '));
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
            throw new \yii\web\NotAcceptableHttpException(Yii::t('widgets', 'No Permission to View Position '));
        }
    }

    public function actionDelete($tech_name) {
        if (\yii::$app->user->can($this->permissionName)) {
            if ($this->findModel($tech_name)->delete()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('widgets', 'Position : {tech_name} deleted', ['tech_name' => $tech_name]));
            }
            return $this->redirect(['index']);
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('widgets', 'No Permission to Delete Position '));
        }
    }

    public function actionRebuild() {
        if (\yii::$app->user->can($this->permissionName)) {
            $contitions = "";
            $positions = Positions::find()->all();
            foreach ($positions as $position) {
                PositionHelper::BuildPosition($position->tech_name);
            }
            Yii::$app->getSession()->setFlash('success', Yii::t('widgets', 'Rebuild All Positions ! '));
            return $this->redirect(['index']);
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('widgets', 'No Permission to Rebuild '));
        }
    }

    public function actionRebuildposition($tech_name) {
        if (\yii::$app->user->can($this->permissionName)) {
            PositionHelper::BuildPosition($tech_name);
            Yii::$app->getSession()->setFlash('success', Yii::t('widgets', 'Rebuild Position {tech_name} ! ', ['tech_name' => $tech_name]));
            return $this->redirect(['index']);
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('widgets', 'No Permission to Rebuild Position '));
        }
    }

    protected function findModel($tech_name) {
        if (($model = Positions::findOne($tech_name)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('widgets', 'The requested page does not exist !'));
        }
    }

}
