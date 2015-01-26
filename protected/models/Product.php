<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property integer $id
 * @property string $product_name
 * @property integer $cost
 * @property integer $cost_sale
 * @property string $image_link
 * @property integer $category_id
 * @property integer $product_sale
 * @property integer $product_new
 * @property string $content
 * @property string $description
 * @property string $created
 * @property string $modified
 */
class Product extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_name, category_id', 'required'),
			array('cost, cost_sale, category_id, product_sale, product_new', 'numerical', 'integerOnly'=>true),
			array('product_name', 'length', 'max'=>255),
			array('content, description, created, modified', 'safe'),
			array('image_link','file',
				'types'=>'jpg,gif,png',
				'maxSize'=> 1024 * 1024 * 10,
				'tooLarge'=>'Anh tai len lon hon 10M, tai lai anh khac nhanh khong thi bao.',
				'allowEmpty'=>true,
				'on'=>'insert,update',
			),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, product_name, cost, cost_sale, image_link, category_id, product_sale, product_new, content, description, created, modified', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'product_name' => 'Product Name',
			'cost' => 'Cost',
			'cost_sale' => 'Cost Sale',
			'image_link' => 'Image Link',
			'category_id' => 'Category',
			'product_sale' => 'Product Sale',
			'product_new' => 'Product New',
			'content' => 'Content',
			'description' => 'Description',
			'created' => 'Created',
			'modified' => 'Modified',
		);
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
		$criteria->compare('product_name',$this->product_name,true);
		$criteria->compare('cost',$this->cost);
		$criteria->compare('cost_sale',$this->cost_sale);
		$criteria->compare('image_link',$this->image_link,true);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('product_sale',$this->product_sale);
		$criteria->compare('product_new',$this->product_new);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			/* Khi hiển thị màn hình admin quản lý các product mình muốn hiển thị các product mới được tạo
			lên trước thì thêm trường sort này để thay đổi điều kiện sort mặc định của.
			Như vậy ta sẽ được dữ liệu đưa ra được sắp xếp từ cao đến thấp theo trường ID.
			*/
			'sort'=>array(
				'defaultOrder'=>'id DESC',
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Product the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function behaviors()
	{
		return array('CTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'created',
				'updateAttribute' => 'modified',
				'setUpdateOnCreate' => 'true',
			),
		);
	}
	/**
	* @param $limit
	* @return random sản phẩm, view hiển thị trong phần sản phầm nổi bật trên trang home.php
	*/
	function getProductFeatured($limit = null)
	{
		$options['select'] = 'id, product_name, image_link';
		$options['order'] = 'rand()';
		$options['limit'] = $limit;

		$data = Product::model()->findAll($options);
		return $data;
	}
}
