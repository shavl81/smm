<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $selectVK app\models\SelectVKForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\helpers\Url;

$this->title = 'Выборка аккаунтов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php $form = ActiveForm::begin(['id' => 'selectVK']); ?>
        <?= $form->field($selectVK, 'q')->label('Поиск') ?>
		<?= $form->field($selectVK, 'country')->label('Страна')->widget(
			AutoComplete::className(),[
			'clientOptions' => [
				'source' => $countries,
				'autoFill' => true,
				'select' => new JsExpression('onAutoCompleteCountry')
			],
			'options' => ['class' => 'form-control', 'placeholder' => 'Введите страну..']]) ?>
		<?= $form->field($selectVK, 'city')->label('Город')->widget(
			AutoComplete::className(),[
			'class' => 'ui-autocomplete-input',
			'clientOptions' => [
				'minLength' => 2,
				'source' => new JsExpression('citySource'),
				'select' => new JsExpression('onAutoComplete')
			],
			'options' => ['class' => 'form-control', 'placeholder' => 'Введите город..', 'disabled' => 'disabled']]) ?>
			
		<?= $form->field($selectVK, 'sex')->label('Пол')->dropDownList([
				'0' => 'Любой',
				'1' => 'Женский',
				'2' => 'Мужской']) ?>
				
		<?= $form->field($selectVK, 'status')->label('Семейное положение')->dropDownList([
				'0' => 'Любое',
				'1' => 'Не женат (Не замужем)',
				'2' => 'Встречается',
				'3' => 'Помолвлен(-а)',
				'4' => 'Женат (Замужем)',
				'5' => 'Всё сложно',
				'6' => 'В активном поиске',
				'7' => 'Влюблен(-а)',
				'8' => 'В гражданском браке',
				]) ?>
		<?php $age = []; for ($i = 14; $i <= 80; $i++) $age[$i] = $i; ?>
		<?= $form->field($selectVK, 'age_from')->label('Возраст от')->dropDownList($age, ['prompt' => 'От'])?>
		<?= $form->field($selectVK, 'age_to')->label('Возраст до')->dropDownList($age, ['prompt' => 'До'])?>
			
		<?= $form->field($selectVK, 'group_id')->label('Членство в группе')->widget(
			AutoComplete::className(),[
			'class' => 'ui-autocomplete-input',
			'clientOptions' => [
				'minLength' => 2,
				'source' => new JsExpression('groupSource'),
				'select' => new JsExpression('onAutoComplete')
			],
			'options' => ['class' => 'form-control', 'placeholder' => 'Введите ссылку или короткое имя..']]) ?>
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end();
		$js = "$('#selectVK').on('beforeSubmit', submitSelect);";
		$this->registerJs($js);
	?>
	<div id="find_result"></div>
</div>
