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

		$item_list = new \common\models\search\ProductSearch;

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

				$query = $item_list->search(['category' => $maincats->id,'subcategory' => $subcheck]);
				
			}
			else
			{	

				$query = $item_list->search(['category' => $maincats->id]);
			}
		}
		else 
		{
				$query = $item_list->search([]);
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