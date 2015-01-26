<?php

class RelationalController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actionIndex()
	{
		/* Lấy ra thông tin về bài post có ID là 1. Như thế nay thì ta chỉ xem được các thuộc tính 
		bài post được khai báo trong bảng tbl_post. */
		$post = TblPost::model()->findByPk(1);
		// Như thế này thì ta sẽ lấy được thông tin của user đã post bài post đó.
		$author = $post->author;
		/* Ta cũng có thể gọi lấy ra thông tin của người post và thông tin bài post được hiển thị.*/
		$post_1 = TblPost::model()->with('author')->findByPk(1);
		/* Nếu ta muốn hiển thị nhiều hơn về bài post như là thông tin về category mà bài post đó thuộc
		   và cả thông tin người post trong một lần lấy thì có thể sử dụng như sau.
		*/
		$post_2 = TblPost::model()->with('author', 'categories')->findByPk(1);
		/* Không muốn dừng lại chỉ có thể tìm kiếm theo ID ta muốn hiển thị thông tin của tất cả các bài post
			cùng với các thông tin liên quan về người post, category mà bài post đó thuộc thì ta có thể làm như
			sau.
		*/
		$post_3 = TblPost::model()->with('author', 'categories')->findAll();
		/* Nếu ta muốn hiển thị nhiều hơn về thông tin người post như profile và các bài post của người đó thì ta
			có thể làm như sau.
		   Nhìn bên dưới ta thấy có khai báo author.profile, author.posts những trường này đã được khai báo trong 
		   model của TblUser (Nhìn vào đó ta có thể hiểu rõ ngay ý nghĩa của nó.)
		*/
		$post_4 = TblPost::model()->with(
			'author.profile',
			'author.posts',
			'categories'
		)->findByPk(1);
		/* Ngoài ra ta có thể kết hợp với các điệu kiện select để có thể đưa ra những kết quả mà mình 
			mong muốn nhất.
		   Như dưới đây kết hợp với xét limit là 3, order by theo trường ID trong bảng post để đưa ra thông tin
		   mình mong muốn hơn về user và các bài post của user đó.
		*/
		$user = TblUser::model()->with(
			array(
				'posts'=>array(
					'limit'=>3,
					'order'=>'posts.id DESC',
				),
			)
		)->findAll();
		print_r('<pre>');
		print_r($user);
		print_r('</pre>');
		exit();
	}
}