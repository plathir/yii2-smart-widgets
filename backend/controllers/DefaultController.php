<?php

namespace plathir\widgets\backend\controllers;

use yii;
use yii\web\Controller;
use \plathir\widgets\backend\models\Widgets;
use plathir\widgets\backend\models\search\Widgets_s;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

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

    /**
     * 
     * @return type
     */
    
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

        if ($model->load(Yii::$app->request->post())) {
            // Get selection_parameters variant from widget type class
            // write some code here 

            $type_model = \plathir\widgets\backend\models\WidgetsTypes::findOne($model->widget_type);

            $widget_class = $type_model->widget_class;
            $tmpWidget = new $widget_class();
            if (property_exists($tmpWidget, 'selection_parameters')) {
                $selection_parameters = $tmpWidget->selection_parameters;
                if ($model->config == '') {
                    $model->config = json_encode($selection_parameters);
                }
            }
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('widgets', 'Widget : {id} created ! ', ['id' => $model->id]));
                return $this->redirect(['index']);
            } else {
                return $this->render('create', [
                            'model' => $model
                ]);
            }
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
            Yii::$app->getSession()->setFlash('success', Yii::t('widgets', 'Widget : {id} deleted ! ', ['id' => $id]));
        }
        return $this->redirect(['index']);
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    public function actionUpdateparams($id) {
        $model = $this->findModel($id);
        $model->selection_parameters = json_decode($model->config);
        if ($model->selection_parameters == '') {

            $type_model = \plathir\widgets\backend\models\WidgetsTypes::findOne($model->widget_type);
            $widget_class = $type_model->widget_class;
            $tmpWidget = new $widget_class();
            if (property_exists($tmpWidget, 'selection_parameters')) {
                $selection_parameters = $tmpWidget->selection_parameters;
                if ($model->config == '') {
                    $model->selection_parameters = $selection_parameters;
                }
            }
        }

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

    /**
     * 
     * @param type $id
     */
    public function actionPreview($id) {

        return $this->render('preview', [
                    'widget_id' => $id
        ]);
    }

    /**
     * 
     * @param type $id
     * @return type
     * @throws NotFoundHttpException
     */
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
