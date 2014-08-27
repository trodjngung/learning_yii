<?php if (isset($csvData) && $csvData != false) {
echo "<h3>File csv tai len thanh cong</h3>";
echo '<table border="1" style="width:500px">';
	foreach ($csvData as $key => $value) {
		echo '<tr>';
			foreach ($value as $key => $data) {
				echo '<td>';
				echo $data;
				echo '</td>';
			}
		echo '</tr>';
	}
echo '</table>';
}
if(isset($csvData) && $csvData == false) {
	echo '<h3>File tai len bi loi. Xin vui long tai lai file.</h3>';
} ?>
<h3>Upload file csv</h3>
<div class="form">	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'login-form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
		'method'=>'post',
		'htmlOptions'=>array('enctype'=>'multipart/form-data'),
	)); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'file'); ?>
		<?php echo $form->fileField($model, 'file'); ?>
		<?php echo $form->error($model, 'file'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>
	<?php $this->endWidget(); ?>
</div>
<h3>Tai file csv</h3>
<?php echo CHtml::link('Download', array('site/CsvDownload')); ?>
