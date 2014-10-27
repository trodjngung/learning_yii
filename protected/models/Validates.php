<?php

class Validates extends CFormModel
{
	public $username;
	public $password;
	public $password_repeat;
	public $email;
	public $captcha;
	public $input_number;
	public $my_date;
	public $input_1;
	public $input_2;
	public $input_number_1;
	public $file;


	public function rules()
	{
		return array(
			//required dùng để khai báo input không được để trống.
			array('username, password, password_repeat', 'required'),
			//Kiểm tra giá trị password_reqeat nhập vào có bằng giá trị password nhập vào trước đó không
	        array('password_repeat', 'compare', 'compareAttribute'=>'password'),
	        //check email
	        array('email', 'email'),
	        //check captcha
	        array('captcha', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
	        //check input_number
	        array('input_number', 'numerical', 'integerOnly'=>true),
	        //date xác thực kiểu date này được hỗ trợ từ yii 1.1.7
	        array('my_date', 'date', 'format' => 'yyyy-M-d H:m:s'),
	        //Max với min khi input định dạng là integer thì có thể sử dụng là giá trị max với giá trị min, khi input là string thì sẽ check độ dài của string đó.
	        //check độ dài
	        array('input_1', 'length', 'max'=>7,'min'=>2),
	        //check input_number_1
	        array('input_number_1', 'numerical', 'integerOnly'=>true, 'max'=>30, 'min'=>10),
	        //file uploat
	        array('file', 'file',
					'types'=>'jpg',
					'maxSize'=>2014*2014*10, //10M
					'tooLarge'=>'Tap tin lon hon 10M, xin hay tai len tap tin nho hon.',
					'allowEmpty'=>true,
				),
	        //match, pattern: dùng để có thể tùy biến nhiều kiểu check đầu vào của dữ liệu
	        array('input_2', 'match', 'pattern'=>'/^\w+$/', 'message'=>'trodjngung'),
		);
	}
}