<?php

namespace plathir\widgets\backend\models;

use yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use plathir\widgets\backend\models\PositionsSortOrder;
use plathir\widgets\common\helpers\PositionHelper;
use plathir\widgets\backend\models\WidgetsTypes;
use plathir\widgets\backend\models\Positions;

class Widgets extends \yii\db\ActiveRecord {

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
            [['widget_type'], 'required'],
            [['id', 'widget_type', 'publish'], 'integer'],
            [['name', 'description', 'position', 'config', 'rules'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['widgettypedescr'], 'string'],
            [['positiondescr'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'description' => Yii::t('app', 'Description'),
            'widgettypedescr' => Yii::t('app', 'Widget Type'),
            'positiondescr' => Yii::t('app', 'Position'),
            'publishbadge' => Yii::t('app', 'Publish'),
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
                   $badge = '<span class="label label-danger">Unpublished</span>';
                   break;
               case 1:
                    $badge = '<span class="label label-success">Published</span>';
                   break;
               default:
                   break;
           }

        return $badge;
        
       }
}
