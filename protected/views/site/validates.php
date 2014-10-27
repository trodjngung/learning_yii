<h3>Validates form</h3>
<div class="form">	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'validates-form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
		'method'=>'post',
		'htmlOptions'=>array('enctype'=>'multipart/form-data'),
	)); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?><!-- Khai báo trường nhập password -->
		<?php echo $form->error($model,'password'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'password_repeat'); ?>
		<?php echo $form->passwordField($model,'password_repeat'); ?>
		<?php echo $form->error($model,'password_repeat'); ?>
	</div>

	<!-- Check email -->
	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<!-- check number -->
	<div class="row">
		<?php echo $form->labelEx($model,'input_number'); ?>
		<?php echo $form->textField($model,'input_number'); ?>
		<?php echo $form->error($model,'input_number'); ?>
	</div>

	<!-- check date -->
	<div class="row">
		<?php echo $form->labelEx($model,'my_date'); ?>
		<?php echo $form->textField($model,'my_date'); ?>
		<?php echo $form->error($model,'my_date'); ?>
	</div>

	<!-- check input 1 -->
	<div class="row">
		<?php echo $form->labelEx($model,'input_1'); ?>
		<?php echo $form->textField($model,'input_1'); ?>
		<?php echo $form->error($model,'input_1'); ?>
	</div>

	<!-- check input 2 -->
	<div class="row">
		<?php echo $form->labelEx($model,'input_2'); ?>
		<?php echo $form->textField($model,'input_2'); ?>
		<?php echo $form->error($model,'input_2'); ?>
	</div>
	
	<!-- check input_number_1 -->
	<div class="row">
		<?php echo $form->labelEx($model,'input_number_1'); ?>
		<?php echo $form->textField($model,'input_number_1'); ?>
		<?php echo $form->error($model,'input_number_1'); ?>
	</div>

	<!-- file upload -->
	<div class="row">
		<?php echo $form->labelEx($model,'file'); ?>
		<?php echo $form->fileField($model, 'file'); ?>
		<?php echo $form->error($model, 'file'); ?>
	</div>

	<!-- check captcha -->
	<?php if(CCaptcha::checkRequirements()): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'captcha'); ?>
		<div>
		<?php $this->widget('CCaptcha'); ?>
		<?php echo $form->textField($model,'captcha'); ?>
		</div>
		<div class="hint">Please enter the letters as they are shown in the image above.
		<br/>Letters are not case-sensitive.</div>
		<?php echo $form->error($model,'captcha'); ?>
	</div>
	<?php endif; ?>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>
	<?php $this->endWidget(); ?>
</div>
