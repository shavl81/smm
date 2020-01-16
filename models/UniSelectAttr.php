<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "uni_select_attr".
 *
 * @property int $uni_select_attr_id
 * @property int $uni_select_id
 * @property int $attr_type_id
 * @property double $nval
 * @property string $cval
 *
 * @property UniSelect $uniSelect
 * @property UniSelectAttrType $attrType
 */
class UniSelectAttr extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'uni_select_attr';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uni_select_id', 'attr_type_id'], 'required'],
            [['uni_select_id', 'attr_type_id'], 'integer'],
            [['nval'], 'number'],
            [['cval'], 'string', 'max' => 100],
            [['uni_select_id'], 'exist', 'skipOnError' => true, 'targetClass' => UniSelect::className(), 'targetAttribute' => ['uni_select_id' => 'uni_select_id']],
            [['attr_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => UniSelectAttrType::className(), 'targetAttribute' => ['attr_type_id' => 'attr_type_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'uni_select_attr_id' => 'Uni Select Attr ID',
            'uni_select_id' => 'Uni Select ID',
            'attr_type_id' => 'Attr Type ID',
            'nval' => 'Nval',
            'cval' => 'Cval',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUniSelect()
    {
        return $this->hasOne(UniSelect::className(), ['uni_select_id' => 'uni_select_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttrType()
    {
        return $this->hasOne(UniSelectAttrType::className(), ['attr_type_id' => 'attr_type_id']);
    }
}
