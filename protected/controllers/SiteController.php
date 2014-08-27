<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->name}<br>".
					"Reply-To: {$model->email}<br>".
					"Content: <br>"."{$model->body}";
				$message = new YiiMailMessage;
				$message->setBody($headers, 'text/html');
				$message->subject = $model->subject;
				// Send mail cho một địa chỉ mail
				$message->addTo('ngoduytrung2901@gmail.com');
				//Send mail cho nhiều địa chỉ mail
				//$message->setTo(array('ngoduytrung2903@gmail.com', 'ngoduytrung2901@gmail.com'));
				//setCc(), setBcc() viết tương tự như setTo()
				//Địa chỉ mủa mail gửi đi và tên muốn đặt.
				$message->setFrom(Yii::app()->params['adminEmail'], 'Admin');
				//Địa chỉ mail nhận trả lời của những mail đã giử tới
				$message->setReplyTo('ngo.duy.trung@framgia.com');
				//gửi file đính kèm
				$file_path = 'protected/controllers/UserController.php';
				// $image = CUploadedFile::getInstance($model, 'image');
				// $file_path = $image->tempName;
				$swiftAttachment = Swift_Attachment::fromPath($file_path);
				$message->attach($swiftAttachment);

				Yii::app()->mail->send($message);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	/*
	* Read file csv
	*/
	public function actionCsv()
	{
		$model=new CsvForm;
		$csvData = null;
		if (isset($_POST['CsvForm'])) {
			
			$model->attributes=$_POST['UserImportForm'];
			if($model->validate()){
				$csvFile=CUploadedFile::getInstance($model,'file');  
                $filePath=$csvFile->getTempName();
                $csvData = $this->CsvFileToString($filePath);
			}
			
		}
		$this->render('csv', array('model'=>$model, 'csvData'=>$csvData));

	}
	/*
	* Chuyen du lieu trong csv tu string sang arrary
	*/
	public function CsvFileToString($filePath)
	{
		if (file_exists($filePath)) {
			$file_handle = fopen($filePath, "r");
			$csvData = null;
			while ($data = fgetcsv($file_handle)) {
				$csvData[] = $data;
			}
			fclose($file_handle);
			return $csvData;
		} else {
			return false;
		}
	}
	/*
	* Tai du lieu ve duoi dang file csv
	*/
	public function actionCsvDownload()
	{
		$csvData = null;
		$csvData[] = array('name','email','password');
		$csvData[] = array('trung_1','email@fa.com','123456');
		$csvData[] = array('trung_2','email@fa.com','123456');
		$csvData[] = array('trung_3','email@fa.com','123456');
		$csvData[] = array('trung_4','email@fa.com','123456');
		$csvData[] = array('trung_5','email@fa.com','123456');
		$csvData[] = array('trung_6','email@fa.com','123456');
		$csvData[] = array('trung_7','email@fa.com','123456');
		
		$csv = new CsvExtensions;
		foreach ($csvData as $key => $value) {
			$csv->addRow($value);
		}
		$title = 'filecsv'.date('d-m-Y H-i');
		echo $csv->render($title,'UTF-8');
		exit;
	}
}