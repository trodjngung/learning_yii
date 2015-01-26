<?php

class TblUser extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_user';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		/* Biều hiện mối quan hệ giữa user với post và giữa user với profile
			Ta có thể thấy quan hệ:
			+ Một user có thể post nhiều bài posts.
			+ Mỗi một user thì chỉ có một profile cho nó.
		   Chú ý:
		   	Ta đang so sánh trường ID trong Tbluser với các bảng khác nên cần khai báo trường của
		   	các bảng tương ứng để thể hiện mối liên quan giữa chúng.
		*/
		return array(
            'posts'=>array(self::HAS_MANY, 'TblPost', 'author_id'),
            'profile'=>array(self::HAS_ONE, 'TblProfile', 'owner_id'),
        );
	}
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
