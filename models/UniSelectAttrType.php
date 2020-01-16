<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "uni_select_attr_type".
 *
 * @property int $attr_type_id
 * @property string $attr_type_name
 * @property string $attr_type_str_id Строковый id типа
 *
 * @property UniSelectAttr[] $uniSelectAttrs
 */
class UniSelectAttrType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'uni_select_attr_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['attr_type_name', 'attr_type_str_id'], 'required'],
            [['attr_type_name', 'attr_type_str_id'], 'string', 'max' => 15],
            [['attr_type_str_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'attr_type_id' => 'Attr Type ID',
            'attr_type_name' => 'Attr Type Name',
            'attr_type_str_id' => 'Attr Type Str ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUniSelectAttrs()
    {
        return $this->hasMany(UniSelectAttr::className(), ['attr_type_id' => 'attr_type_id']);
    }
}
