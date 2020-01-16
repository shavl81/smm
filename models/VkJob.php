<?php

namespace app\models;

use Yii;
use app\models\UniSelectAttr;
use app\models\Consts;
use VK\Client\VKApiClient;

/**
 * Job задание для отправки сообщений в VK.
 *
 * @property int $uniSelect
 * @property string $message
 *
 */
class VkJob extends yii\base\BaseObject implements \yii\queue\JobInterface
{
	public $uniSelect;
	public $message;

    public function execute($queue)
    {
		try {
			$query =
				'select at.attr_type_str_id id, ifnull(sa.nval, sa.cval) val
				 from uni_select_attr sa,
					  uni_select_attr_type at
				 where sa.attr_type_id = at.attr_type_id
				   and sa.uni_select_id = :sel_id';
			$select = UniSelectAttr::findBySql($query, [':sel_id' => $this->uniSelect])->asArray()->all();
			
			$vk_params = array();
			
			foreach ($select as $sel)
				$vk_params[$sel['id']] = $sel['val'];
			$vk_params['count'] = Consts::VK_PAGE_SIZE;
			$vk = new VKApiClient();
			$response = $vk->users()->search(Consts::VK_ACCESS_TOKEN_GET_INFO, $vk_params);
			$response = $response['items'];
			foreach ($response as $vk_rec)
			{
				$param_message = [
					'user_id' => $vk_rec['id'],
					'message' => $this->message,
					'random_id' => $vk_rec['id'] . rand(0, 999999)
				];
				$vk->messages()->send(Consts::VK_ACCESS_TOKEN_SEND, $param_message);
			}
		} catch (\Exception $e) {
			echo 'Crash exception VkJob: ' . $e->getMessage() . "\n";
		}
    }
}
