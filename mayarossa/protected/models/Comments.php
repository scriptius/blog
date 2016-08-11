<?php

/**
 * This is the model class for table "Comments".
 *
 * The followings are the available columns in table 'Comments':
 * @property integer $id
 * @property integer $userId
 * @property string $content
 * @property integer $raiting
 * @property integer $parentPost
 * @property integer $parentComment
 * @property integer $updated_at
 * @property integer $created_at
 *
 * The followings are the available model relations:
 * @property Comments $parentComment0
 * @property Comments[] $comments
 * @property Posts $parentPost0
 */
class Comments extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Comments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userId, content, updated_at, created_at', 'required'),
			array('userId, raiting, parentPost, parentComment, updated_at, created_at', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, userId, content, raiting, parentPost, parentComment, updated_at, created_at', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'parentComment0' => array(self::BELONGS_TO, 'Comments', 'parentComment'),
			'comments' => array(self::HAS_MANY, 'Comments', 'parentComment'),
			'parentPost0' => array(self::BELONGS_TO, 'Posts', 'parentPost'),
			'author' => array(self::BELONGS_TO, 'Users', 'userId')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'userId' => 'Id пользователя',
			'content' => 'Введите текст комментария',
			'raiting' => 'Raiting',
			'parentPost' => 'Parent Post',
			'parentComment' => 'Parent Comment',
			'updated_at' => 'Updated At',
			'created_at' => 'Created At',
		);
	}

	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
				$this->created_at = time();
			return true;
		}
		else
			return false;
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('raiting',$this->raiting);
		$criteria->compare('parentPost',$this->parentPost);
		$criteria->compare('parentComment',$this->parentComment);
		$criteria->compare('updated_at',$this->updated_at);
		$criteria->compare('created_at',$this->created_at);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Comments the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
