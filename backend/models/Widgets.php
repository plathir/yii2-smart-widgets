<?php

namespace plathir\widgets\backend\models;

use yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use plathir\widgets\backend\models\PositionsSortOrder;
use plathir\widgets\common\helpers\PositionHelper;

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
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'description' => Yii::t('app', 'Description'),
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

}
