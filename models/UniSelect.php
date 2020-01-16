<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "uni_select".
 *
 * @property int $uni_select_id
 * @property string $select_name
 *
 * @property UniSelectAttr[] $uniSelectAttrs
 */
class UniSelect extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'uni_select';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['select_name'], 'required'],
            [['select_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'uni_select_id' => 'Uni Select ID',
            'select_name' => 'Select Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUniSelectAttrs()
    {
        return $this->hasMany(UniSelectAttr::className(), ['uni_select_id' => 'uni_select_id']);
    }
}
