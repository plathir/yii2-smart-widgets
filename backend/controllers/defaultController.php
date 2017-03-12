<?php

namespace plathir\widgets\backend\controllers;

use yii;
use yii\web\Controller;
use \plathir\widgets\backend\models\Widgets;
use plathir\widgets\backend\models\search\Widgets_s;
use yii\filters\VerbFilter;

/**
 * @property \plathir\widgets\backend\Module $module
 *
 */
class DefaultController extends Controller {

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
        $searchModel = new Widgets_s();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate() {
        $model = new Widgets();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('widgets', 'Widget : {id} created ! ', ['id' => $model->id]));
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
            Yii::$app->getSession()->setFlash('success', Yii::t('widgets', 'Widget : {id} updated ! ', ['id' => $model->id]));
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                        'model' => $model
            ]);
        }
    }

    public function actionView($id) {
        $model = $this->findModel($id);

        return $this->render('view', [
                    'model' => $model
        ]);
    }

    public function actionDelete($id) {
        if ($this->findModel($id)->delete()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('widgets', 'Widget : {id} deleted ! ', ['id' => $model->id]));
        }
        return $this->redirect(['index']);
    }

    public function actionUpdateparams($id) {
        $model = $this->findModel($id);
        $model->selection_parameters = json_decode($model->config);
        if ($model->load(Yii::$app->request->post())) {
            $newParams = Yii::$app->request->post()['Widgets']['selection_parameters'];
            $model->config = json_encode($newParams);
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('widgets', 'Widget : {id} parameters updated ! ', ['id' => $model->id]));
                return $this->redirect(['index']);
            } else {
                return $this->render('update_params', [
                            'model' => $model
                ]);
            }
        } else {
            return $this->render('update_params', [
                        'model' => $model
            ]);
        }
    }

    protected function findModel($id) {
        if (($model = Widgets::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('widgets', 'The requested page does not exist.'));
        }
    }

    public function getModuleslist() {

        $newItems = \plathir\widgets\common\helpers\WidgetHelper::getListOfModules();

        return $newItems;
    }

}
