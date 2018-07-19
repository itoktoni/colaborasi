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

		$this->enableCsrfValidation = false;


		$maincats = false;
		$subcheck = false;

		$this->view->params['menu'] = 'shop';

		$item_list = new \common\models\search\ProductSearch;

		$filter = [];

		if(YII::$app->request->get()){
			$filter = YII::$app->request->get();
		}


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
				
				$filter['category'] = $maincats->id;
				$filter['subcategory'] = $subcheck;
				$query = $item_list->search($filter);
				
			}
			else
			{	
				$filter['category'] = $maincats->id;
				$query = $item_list->search($filter);
			}
		}
		else 
		{
				$query = $item_list->search($filter);
		}

		
		$pages 		= $query->getPagination();
		$models 	= $query;

		$max = $item_list->getMax();
		$min = $item_list->getMin();

		return $this->render('index', [
			'max' 			=> $max,
			'min'			=> $min,
			'pages' 		=> $pages,
			'products' 		=> $models,
			'category' 		=> $maincats,
			'subcategory' 	=> $subcheck,
		]);
	}
}