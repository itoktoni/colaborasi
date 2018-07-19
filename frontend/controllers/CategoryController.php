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

		$this->view->params['menu'] = 'shop';

		if ($cats) {
			$maincats = Category::findOne(['slug' => $cats]);

			if ( !$maincats )
			{
				throw new \yii\web\NotFoundHttpException();
			}
 
			if ( $maincats && $subcategory )
			{
				$subcheck 	= Subcategory::findOne( ['category' => $maincats->id, 'slug' => $subcategory] ); 
				if (!$subcheck)
				{
					throw new \yii\web\NotFoundHttpException();
				}

				// $item_list 	= Product::find()
				// 				->join( 'LEFT JOIN', 'product_category', 'product.id = product_category.product')
				// 				->join( 'LEFT JOIN', 'sub_category', 'sub_category.id = product_category.sub_category' )
				// 				->where( ['sub_category.id' => $subcheck->id] ); 

				$item_list = new \common\models\search\ProductSearch;
				$query = $item_list->search(Yii::$app->request->post());
			}
			else
			{
				$item_list 	= Product::find()
								->join('LEFT JOIN','category','category.id = product.category')
								->where(['category.id' => $maincats->id]);
			}
		}
		else {
			$item_list = Product::find()
				->join('LEFT JOIN','sub_category','product.category=sub_category.id')
				->join('LEFT JOIN','category','category.id=sub_category.category');
		}

		
		$pages 		= $query->getPagination();
		$models 	= $query->getModels();

		return $this->render('index', [
			'pages' 		=> $pages,
			'products' 		=> $models,
			'category' 		=> $maincats,
			'subcategory' 	=> $subcheck,
		]);
	}
}