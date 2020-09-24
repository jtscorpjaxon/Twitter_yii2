<?php


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Сменить пароль';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Пожалуйста, выберите новый пароль:</p>

    <div class="row">
        <?php $form = ActiveForm::begin(); ?>

        <div class="col-lg-5">

            <?= $form->field($model, 'currentPassword')->passwordInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'newPassword')->passwordInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'newPasswordRepeat')->passwordInput(['maxlength' => true]) ?>

            <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
                </div>


        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'birthday')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '99/99/9999',]); ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
