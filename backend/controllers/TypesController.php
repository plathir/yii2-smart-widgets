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
            Yii::$app->getSession()->setFlash('success', 'Type : ' . $model->id . ' created !');
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
            Yii::$app->getSession()->setFlash('success', 'Type : ' . $model->id . ' updated !');
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
            Yii::$app->getSession()->setFlash('success', 'Type : ' . $id . ' Deleted ! ');
        }
        return $this->redirect(['index']);
    }

    protected function findModel($id) {
        if (($model = WidgetsTypes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
