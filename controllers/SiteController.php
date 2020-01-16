<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use VK\Client\VKApiClient;
use app\models\SelectVKForm;
use app\models\SenderForm;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use app\models\UniSelect;
use app\models\UniSelectAttr;
use app\models\UniSelectAttrType;
use app\models\Consts;
use app\models\VkJob;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
	
	/**
	 * Страница "Выборка акаунтов"
	 * @return string
	 */
    public function actionSelect()
    {
		$vk = new VKApiClient();
		$access_token = Consts::VK_ACCESS_TOKEN_GET_INFO;
		$selectVK = new SelectVKForm();
		
		if (Yii::$app->request->isAjax)
		{
			Yii::$app->response->format = Response::FORMAT_JSON;
			
			$data = array();
			if (!isset(Yii::$app->request->post()['method']))
			{
				$data['params'] = Yii::$app->request->get();
				$data['method'] = 'findVK';
			}
			else
				$data = Yii::$app->request->post();
			
			switch ($data['method'])
			{
				case 'getCities':
					$cities = $vk->database()->getCities($access_token, array(
						'country_id' => $data['country_id'],
						'need_all' => true,
						'q' => $data['term'],
						'count' => 1000
					));
					
					$cities = $cities['items'];
					$tmp = array();
					foreach ($cities as $key => $val) {
						$name = $val['title'];
						$area = $val['area'];
						$region = $val['region'];
						
						if ($area != null || $region != null)
							$name = "$name (" . trim($area . " " . $region) . ")";
						
						$tmp[$key]['value'] = $name;
						$tmp[$key]['id'] = $val['id'];
					}
					$cities = $tmp;
					return $cities;
				case 'getGroup':
					try {
						$group = $vk->groups()->getById($access_token, array(
							'group_id' => $data['term'],
						));
						
						$tmp = array();
						$tmp[0]['id'] = $group[0]['id'];
						$tmp[0]['value'] = $group[0]['name'];
						$group = $tmp;
						return $group;
					} catch (\Exception $ex) {
						return null;
					}
				case 'findVK':
					$params = array();
					if (!isset(Yii::$app->request->post()['method']))
						$params = $data['params'];
					else
						parse_str($data['form'], $params);
					if ($selectVK->load($params))
					{
						$response = $vk->users()->search($access_token, array( 
								'q' => $selectVK->q,
								'count' => Consts::VK_PAGE_SIZE,
								'fields' => array('photo', 'screen_name'),
								'country' => $params['SelectVKForm']['country'],
								'city' => $params['SelectVKForm']['city'],
								'sex' => $selectVK->sex,
								'status' => $selectVK->status,
								'age_from' => $selectVK->age_from,
								'age_to' => $selectVK->age_to,
								'group_id' => $params['SelectVKForm']['group_id']
						));
						
						$response = $response['items'];
						foreach ($response as $k => $v)
							$response[$k]['link'] = 'https://vk.com/' . $v['screen_name'];
						
						$dataProvider = new ArrayDataProvider([
							'allModels' => $response,
							'pagination' => [
								'pageSize' => Consts::VK_PAGE_SIZE
							],
							'sort' => [
								'attributes' => ['first_name', 'last_name'],
							],
						]);
						
						$pagination = $dataProvider->getPagination();
						$pagination->params = array_merge($_GET, $params);
						
						return '<br><div class="row"><div class="form-group col-sm-8"><input type="text" id="selectName" class="form-control" placeholder="Введите название выборки">' .
								Html::a('Сохранить', ['site/saveselect', 'params' => $data['form']], ['class' => 'btn btn-primary', 'onclick' => 'return saveSelect(this);']) .
								'</div></div>' .
							GridView::widget(
							[
								'dataProvider' => $dataProvider,
								'columns' => [
									['class' => 'yii\grid\SerialColumn'],
									'photo:image', 'first_name:ntext', 'last_name:ntext',
									[
										'label' => 'Профиль',
										'format' => 'raw',
										'value' => function ($data){
											return Html::a('Перейти', $data['link'],
												[
													'title' => 'Открыть профиль в новой вкладке',
													'target' => '_blank',
													'class' => 'btn btn-info center-block'
												]);
										}
									]
								],
								'tableOptions' => [
									'class' => 'table table-striped table-bordered'
								]
							]
						);
					}
					return 'Форма отклонена!';
			}
		}
		else
		{
			$countries = $vk->database()->getCountries($access_token, array(
								'need_all' => true,
								'count' => 1000
							));
			$countries = $countries['items'];
			$tmp = array();
			foreach ($countries as $key => $val) {
				$tmp[$key]['value'] = $val['title'];
				$tmp[$key]['id'] = $val['id'];
			}
			$countries = $tmp;
			return $this->render('select', compact('selectVK', 'countries', 'dataProvider'));
		}
    }
	
	/**
	 * Страница "Рассылка"
	 * @return string
	 */
	public function actionSending()
	{
		$sender = new SenderForm();
		$uniSelect = UniSelect::find()->all();
		if ($sender->load(Yii::$app->request->post())) {
			Yii::$app->queue->push(
				new VkJob([
						'uniSelect' => $sender->uniSelect,
						'message' => $sender->message,
					]
				)
			);
        }
		return $this->render('sending', compact('sender', 'uniSelect'));
	}
	
	/**
	 * Сохранение выборки на странице "Рассылка"
	 * @return string
	 */
	public function actionSaveselect()
	{
		$selectVK = new SelectVKForm();
		$data = Yii::$app->request->get();
		$params = array();
		parse_str($data['params'], $params);
		if ($selectVK->load($params))
		{	
			$uniSelectAttrType = UniSelectAttrType::find()->all();
			$transaction = UniSelect::getDb()->beginTransaction();
			try {
				$uniSelect = new UniSelect();
				$uniSelect->select_name = $data['sname'];
				$uniSelect->save();
				
				foreach ($uniSelectAttrType as $attr)
				{
					if (array_key_exists($attr->attr_type_str_id, $params['SelectVKForm']) && $params['SelectVKForm'][$attr->attr_type_str_id] != '')
					{
						$uniSelectAttr = new UniSelectAttr();
						$uniSelectAttr->attr_type_id = $attr->attr_type_id;
						if (is_numeric($params['SelectVKForm'][$attr->attr_type_str_id]))
							$uniSelectAttr->nval = $params['SelectVKForm'][$attr->attr_type_str_id];
						else
							$uniSelectAttr->cval = $params['SelectVKForm'][$attr->attr_type_str_id];
						$uniSelectAttr->uni_select_id = $uniSelect->uni_select_id;
						$uniSelectAttr->save();
					}
				}
				
				$transaction->commit();
			} catch(\Exception $e) {
				$transaction->rollBack();
				throw $e;
			} catch(\Throwable $e) {
				$transaction->rollBack();
				throw $e;
			}
			
			return Yii::$app->response->redirect(['site/sending']);
		}
		else
			return Yii::$app->response->redirect(['site/select']);
	}
}
