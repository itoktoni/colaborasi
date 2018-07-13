<?php 

namespace frontend\controllers;

use Yii;
use common\models\base\Category;
use common\models\base\Subcategory;
use common\models\base\Product;
use yii\data\Pagination;

class CategoryController extends \yii\web\Controller
{
	public function behavior()
	{
		$this->layout = 'main';
	}

	public function actionIndex( $cats = false, $subcategory = false )
	{
		$maincats = false;
		$subcheck = false;

		if ( $cats ) :
			$this->view->params['menu'] = $cats;
			$maincats 					= Category::findOne(['slug' => $cats]);

			if ( !$maincats )
			{
				throw new \yii\web\NotFoundHttpException();
			}

			if ( $maincats && $subcategory )
			{
				$subcheck 	= Subcategory::findOne( ['category' => $maincats->id, 'slug' => $subcategory] ); 
				if ( !$subcheck )
				{
					throw new \yii\web\NotFoundHttpException();
				}

				$item_list 	= Product::find()
								->join( 'LEFT JOIN', 'product_category', 'product.id = product_category.product' )
								->join( 'LEFT JOIN', 'sub_category', 'sub_category.id = product_category.sub_category' )
								->where( ['sub_category.id' => $subcheck->id] ); 
			}
			else
			{
				$item_list 	= Product::find()
								->join('LEFT JOIN','category','category.id = product.category')
								->where(['category.id' => $maincats->id]);
			}
			
			$countQuery 	= clone $item_list;
			$pages 			= new Pagination(['totalCount' => $countQuery->count()]);
			$models 		= $item_list->offset($pages->offset)
								->limit($pages->limit)
								->all();
		else :
			$item_list = Product::find()
				->join('LEFT JOIN','sub_category','product.category=sub_category.id')
				->join('LEFT JOIN','category','category.id=sub_category.category');
		endif;

		$countQuery = clone $item_list;
		$pages 		= new Pagination(['totalCount' => $countQuery->count()]);
		$models 	= $item_list->offset($pages->offset)
						->limit($pages->limit)
						->all();

		return $this->render('index', [
			'pages' 		=> $pages,
			'products' 		=> $models,
			'category' 		=> $maincats,
			'subcategory' 	=> $subcheck,
		]);
	}
}