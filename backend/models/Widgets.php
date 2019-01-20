<?php

namespace plathir\widgets\backend\models;

use yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use plathir\widgets\common\helpers\PositionHelper;
use plathir\widgets\backend\models\WidgetsTypes;
use plathir\widgets\backend\models\Positions;

class Widgets extends \yii\db\ActiveRecord {
    public $selection_parameters = '';
    public $created_at1 = '';
    public static function tableName() {
        return '{{%widgets}}';
    }

    public function behaviors() {
        return [
            'timestampBehavior' =>
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                // if you're using datetime instead of UNIX timestamp:
                'value' => function() {
                    return date('U');
                }
            ]
        ];
    }

    public function rules() {
        return [           
            [['widget_type'], 'string'],
            [['id', 'publish'], 'integer'],
            [['name', 'description', 'position', 'config', 'rules'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['widgettypedescr'], 'string'],
            [['positiondescr'], 'string'],
            ['config',
                function ($attribute, $params) {
                    // Validate json in config
                    $emp_json = json_decode($this->$attribute);
                    if (json_last_error() != null)
                        $this->addError($attribute, Yii::t('widgets', 'json in config not Valid'));
                }
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('widgets', 'ID'),
            'description' => Yii::t('widgets', 'Description'),
            'widgettypedescr' => Yii::t('widgets', 'Widget Type'),
            'positiondescr' => Yii::t('widgets', 'Position'),
            'publishbadge' => Yii::t('widgets', 'Publish'),
        ];
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            $curr = self::findOne($this->id);
            if (!$insert) {
                if ($curr->position <> $this->position) {
                    PositionHelper::RemoveWidgetFromPosition($curr->position, $this->id);
                }
            }
            return true;
        } else {
            return false;
        }
    }

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        // when insert false, then record has been updated
        PositionHelper::BuildPosition($this->position);
    }

    public function afterDelete() {
        parent::afterDelete();
        PositionHelper::BuildPosition($this->position);
    }

    public function getWidgettypedescr() {
        $type = WidgetsTypes::findOne($this->widget_type);
        if ($type) {
            return $type->widget_name;
        } else {
            return null;
        }
    }
    public function getModule_name() {
        $type = WidgetsTypes::findOne($this->widget_type);
        if ($type) {           
            return $type->module_name;
        } else {
            return null;
        }
    }
    
    public function getPositiondescr() {
        $position = Positions::findOne($this->position);
        if ($position) {
            return $position->name;
        } else {
            return null;
        }
    }

    public function getPublishbadge() {
        $badge = '';
        switch ($this->publish) {
            case 0:
                $badge = '<span class="label label-danger">' . Yii::t('widgets', 'Unpublished') . '</span>';
                break;
            case 1:
                $badge = '<span class="label label-success">' . Yii::t('widgets', 'Published') . '</span>';
                break;
            default:
                break;
        }

        return $badge;
    }

    public function setSelection_parameters() {
        return json_decode($this->config);
    }
    
    public function getEnvironment() {
        if ($this->module_name) {
            $h_env = explode('-', $this->module_name);
            if ($h_env) {
                return $h_env[0];
            }
        }
    }
    
}
