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

		// echo $cats.' '.$subcategory; die();

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
<<<<<<< HEAD
			{				
=======
			{
>>>>>>> 3184a9048379e75cb0e13d03d8184bddf083d9dc
				$subcheck 	= Subcategory::findOne( ['category' => $maincats->id, 'slug' => $subcategory] ); 
				if (!$subcheck)
				{
					throw new \yii\web\NotFoundHttpException();
				}
				
				$filter['category'] = $maincats->id;
<<<<<<< HEAD
				$filter['subcategory'] = $subcheck;
				$query = $item_list->search($filter);				
=======
				$filter['subcategory'] = $subcheck->id;
				$query = $item_list->search($filter);
				
>>>>>>> 3184a9048379e75cb0e13d03d8184bddf083d9dc
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