<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $sender app\models\SelectVKForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = 'Рассылка';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
	<?php $form = ActiveForm::begin(['id' => 'sender']); ?>
	<?= $form->field($sender, 'uniSelect')->label('Выборка')->dropDownList(ArrayHelper::map($uniSelect, 'uni_select_id', 'select_name'), ['prompt' => 'Выборка..'])?>
	<?= $form->field($sender, 'message')->label('Сообщение')->textArea(['prompt' => 'Выборка..']) ?>
	<?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
	<?= ($sender->message != '' ? 'Сообщение отправленно по выборке!' : '') ?>
	<?php ActiveForm::end(); ?>
</div>
