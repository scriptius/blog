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
		$posts = Posts::model()->findAll();
		$this->render('index', ['posts' => $posts]);
	}

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
			$this->redirect('/site/article/'.(int) $_POST['postId']);
		}
	}

	public function actionArticle(int $id)
	{
		$comment = new Comments();

		if (isset($_POST['Comments'])){
			$comment->attributes = $_POST['Comments'];
			if($comment->validate()){
				$comment->save();
				Yii::app()->user->setFlash('addComment','Ваш комментарий успешно добавлен');
//				$this->redirect(Yii::app()->user->returnUrl);
//				$this->render('article', ['post' => $post, 'comment' => $comment, 'userId' => Yii::app()->user->id]);
			}
		}
//		else{
//			Yii::app()->user->setFlash('needLogin','Для этой операции требуется регистрация в системе');
//			$this->redirect('site/login');
//		}
//		&& !Yii::app()->user->isGuest

		$post = Posts::model()->findByPk($id);
		$allComments = Comments::model()->findAll('parentPost=:parentPost', [':parentPost'=> $post->id]);


		$this->render('article', ['post' => $post,
			 					  'comment' => $comment,
								  'userId' => Yii::app()->user->id,
								  'allComments' => $allComments,
								  'raitingPost' => (int)$post->raiting,
								  'parentPost' => $post->id]);
	}

	public function actionAddPost()
	{
		if (Yii::app()->user->isGuest){
			Yii::app()->user->setFlash('needLogin','Для этой операции требуется регистрация в системе');
			$this->redirect('site/login');
		}
		
		$model=new Posts;

		// uncomment the following code to enable ajax-based validation
		/*
        if(isset($_POST['ajax']) && $_POST['ajax']==='posts-index-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        */

		if(isset($_POST['Posts']))
		{
			$model->attributes = $_POST['Posts'];

			if($model->validate())
			{
				$model->save();
				Yii::app()->user->setFlash('addPost','Ваш пост успешно добавлен');
				$this->redirect('addPost');
			}
		}
		$this->render('addPost',array('model'=>$model));

	}

	protected function actionComment($post)
	{
		$comment=new Comments();
		if(isset($_POST['Comment']))
		{
			$comment->attributes=$_POST['Comment'];
			if($post->addComment($comment))
			{
				if($comment->status==Comment::STATUS_PENDING)
					Yii::app()->user->setFlash('commentSubmitted','Thank you for your comment.
                Your comment will be posted once it is approved.');
				$this->refresh();
			}
		}
		return $comment;
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