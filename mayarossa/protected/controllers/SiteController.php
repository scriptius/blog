<?php

/**
 * Class SiteController
 * This is the main and currently the only class controller
 *
 * @author Mamonov Viktor
 */

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 * @return array Set actions
	 * @todo Required to create the registration page, which is still in the process of creating
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
	 * Declares filters.
	 * @return array List filters for access control in addComments and addRaiting
	 * @see http://www.yiiframework.com/doc/guide/1.1/ru/basics.controller#sec-5  more about filters
	 */
	public function filters()
	{
		return array(
			'accessControl',
		);
	}

	/**
	 * Declares list rules.
	 * @return array List rules for access control in addComments and addRaiting
	 * * @see http://www.yiiframework.com/doc/guide/1.1/ru/basics.controller#sec-5  more about filters
	 */
	public function accessRules()
	{
		return array(
			array('deny',
				'actions'=>array('AddRaiting', 'AddComment'),
				'users'=>array('?'),
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

		$posts = Posts::model()->findAll();
		$this->render('index', ['posts' => $posts]);
	}

	/**
	 * This is a method for inclusion in the database of user ratings for posts or comments for future
	 */
	public function actionAddRaiting()
	{
		if (isset($_POST['raiting'])){
			 Yii::app()->db->createCommand()
				 		   ->update('Posts',
							   	   ['raiting' => new CDbExpression('raiting + :raiting',
											  					  [':raiting' => (int)$_POST['raiting']])],
							        'id = :id',
							       [':id' => (int) $_POST['postId']]);
			Yii::app()->user->setFlash('addRaitingSuccess','Ваша оценка учтена');
			$this->redirect('/site/article/'.(int) $_POST['postId']); //Redirect to the original page, if the data came from the user
		}else{
			$this->redirect('/site/index');  //Redirect to the home page, if there is no data from the user
		}

	}

	/**
	 * This is a method for inclusion in the database of user comments for posts
	 */
	public function actionAddComment()
	{
		$comment = new Comments();
		if (isset($_POST['Comments'])){
			$comment->attributes = $_POST['Comments'];
			if($comment->validate()) {
				$comment->save();
				Yii::app()->user->setFlash('addComment', 'Ваш комментарий успешно добавлен');
			}
		}
		Yii::app()->request->redirect($_SERVER['HTTP_REFERER']);
	}

	/**
	 * This method generates a page with article
	 * @param integer Post ID in the database
	 */
	public function actionArticle(int $id)
	{
		$comment = new Comments(); //to form a data entry form

		$post = Posts::model()->findByPk($id); //find post by ID
		$allComments = Comments::model()->findAll('parentPost=:parentPost', [':parentPost'=> $post->id]);


		$this->render('article', ['post' => $post,
			 					  'comment' => $comment,
								  'userId' => Yii::app()->user->id,
								  'allComments' => $allComments,
								  'raitingPost' => (int)$post->raiting,
								  'parentPost' => $post->id]);
	}

	/**
	 * This is a method for add Post
	 */
	public function actionAddPost()
	{
		$model=new Posts;

		if(isset($_POST['Posts'])){
			$model->attributes = $_POST['Posts'];
			if($model->validate()){
				$model->save();
				Yii::app()->user->setFlash('addPost','Ваш пост успешно добавлен');
				$this->redirect('addPost');
			}
		}

		$this->render('addPost',array('model'=>$model));

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
	 * @todo not yet ready
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
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
}