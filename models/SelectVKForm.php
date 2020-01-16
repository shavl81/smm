<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Форма для создания выборок
 */
class SelectVKForm extends Model
{
    public $q;
	public $country;
	public $city;
	public $sex;
	public $group_id;
	public $status;
	public $age_from;
	public $age_to;
    
    public function rules()
    {
        return [
			[['q'], 'trim'],
			[['sex'], 'integer'],
			[['status'], 'integer'],
			[['age_from'], 'integer'],
			[['age_to'], 'integer']
		];
    }
}
