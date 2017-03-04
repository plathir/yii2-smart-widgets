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
        \yii\helpers\Url::remember();
        $searchModel = new Positions_s();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate() {
        $model = new Positions();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('widgets', 'Position : {id} created', ['id' => $model->id]));
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                        'model' => $model
            ]);
        }
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->getSession()->setFlash('success', Yii::t('widgets', 'Position : {id} updated', ['id' => $model->id]));
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                        'model' => $model
            ]);
        }
    }

    public function actionView($id) {
        \yii\helpers\Url::remember();
        $model = $this->findModel($id);

        return $this->render('view', [
                    'model' => $model
        ]);
    }

    public function actionDelete($id) {
        if ($this->findModel($id)->delete()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('widgets', 'Position : {id} deleted', ['id' => $model->id]));
        }
        return $this->redirect(['index']);
    }

    public function actionRebuild() {
        $contitions = "";
        $positions = Positions::find()->all();
        foreach ($positions as $position) {
            PositionHelper::BuildPosition($position->id);
        }
        Yii::$app->getSession()->setFlash('success', Yii::t('widgets', 'Rebuild All Positions ! '));
        return $this->redirect(['index']);
    }

    public function actionRebuildposition($position_id) {
        PositionHelper::BuildPosition($position_id);
        Yii::$app->getSession()->setFlash('success', Yii::t('widgets', 'Rebuild Position {id} ! ', ['id' => $position_id]));
        return $this->redirect(['index']);
    }

    protected function findModel($id) {
        if (($model = Positions::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('widgets', 'The requested page does not exist.'));
        }
    }

}
