<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Форма для отправки сообщений по выборке
 */
class SenderForm extends Model
{
    public $uniSelect;
	public $message;
    
    public function rules()
    {
        return [
			[['uniSelect'], 'required'],
			[['message'], 'required']
		];
    }
}
