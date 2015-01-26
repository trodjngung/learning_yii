<?php

$this->breadcrumbs=array(
	'Products'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Product', 'url'=>array('index')),
	array('label'=>'Create Product', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#product-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Products</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//Muốn bỏ cột ID không cho hiển thị thì ta chỉ cần comment cột đó lại.
		// 'id',
		//Muốn thay đổi tên header hiển thị ban đầu thì ta có thể dùng như sau.
		array(
			'name'=>'product_name',
			'header'=>'Tên sản phẩm',
		),
		/* Trường giá tiền muốn hiển thị các số cho đẹp hơn ta có thể dùng numbet_format nối thêm
		đuôi VND trông cho nó giống thật.
		*/
		array(
			'name'=>'cost',
			'header'=>'Giá tiền',
			'value'=>'number_format($data->cost)."VND"',
		),
		array(
			'name'=>'cost_sale',
			'header'=>'Giảm giá',
			'value'=>'number_format($data->cost_sale)."VND"',
		),
		/* Đến trường image_link, lúc đầu chỉ hiển thị text giờ muốn thay vào đó là hiển thị ảnh của product đó
		thì ta sẽ làm như sau.
		+ type để xác định kểu hiển thị của trường đó.
		+ value để xác định giá trị hiển thị trên trường đó.
		*/
		array(
			'header'=>'images',
			'name'=>'image_link',
			'type'=>'image',
			'value'=>'Yii::app()->request->baseUrl."/images/Product/".$data->image_link'
		),
		/* Trường category_id, ta muốn thêm link cho trường đó thì sẽ làm như sau.
		Qua đó ta có thể tùy biến nhiều kiểu của Chtml hỗ trợ không chỉ là tạo link.
		*/
		array(
			'name'=>'category_id',
			'type'=>'raw',
			'value'=>'CHtml::link($data->category_id,"google.com")',
		),
		
		/*
		'product_sale',
		'product_new',
		'content',
		'description',
		'created',
		'modified',
		*/
		/* Nếu ta muốn thêm các sử lý css thì có thể dùng htmlOptions như bên dưới
		Ta cũng có thể thêm class cho thẻ td được sinh ra đó.
		*/
		array(
			'name'=>'created',
                  'htmlOptions'=>array('style'=>'text-align: center', 'class'=>'trodjngung'),
                  'value'=>'date_format(date_create($data->created), "Y-m-d")',
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
