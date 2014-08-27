<?php

class CsvForm extends CFormModel
{
	public $file;

	public function rules()
	{
		return array(
			array('file', 'file',
					'types'=>'csv',
					'maxSize'=>2014*2014*10, //10M
					'tooLarge'=>'Tap tin lon hon 10M, xin hay tai len tap tin nho hon.',
					'allowEmpty'=>false
					),
		);
	}
	public function attributeLabels()
	{
		return array(
			'file'=>'Select file',
		);
	}
}