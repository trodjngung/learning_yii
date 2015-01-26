<?php

class TblPost extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_post';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		/* Biểu hiện mối quan hệ giữa bài post với user và category
			Nhìn vào đây ta có thể thấy quan hệ:
			+ Một bài post thì thuộc một user mà thôi.
			+ Một bài post có thể thuộc nhiều category và ngược lại.
		   Với BELONGS_TO ở đây thì ta để ý đang thể hiện mới quan hệ của bảng TblPost với 
		   bảng TblUser nên trường của bảng TblPost mang ra để so sánh với ID trong TblUser là 'author_id'
		   nhiểu trường hợp ta sẽ nhầm lẫn là so sánh ID của trường TblPost với ID của TblUser.
		*/
		return array(
            'author'=>array(self::BELONGS_TO, 'TblUser', 'author_id'),
            'categories'=>array(self::MANY_MANY, 'TblCategory',
                'tbl_post_category(post_id, category_id)'),
        );
	}
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}