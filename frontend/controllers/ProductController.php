<?php 
namespace frontend\controllers;
use Yii;

use common\models\base\Category;
use common\models\base\Subcategory;
use common\models\base\Product;
use common\models\base\Brand;
use frontend\components\CMS;

class ProductController extends \yii\web\Controller
{
	public function init() {
		parent::init();
		Category::find()->orderBy(['name' => SORT_ASC]);
	}

	public function actionIndex( $slug = false )
	{
		$this->view->params['menu'] = 'shop';
		
		if( !$slug )
		{
			throw new \yii\web\NotFoundHttpException();
		}

		$product 		= Product::find()
							->where(['`product`.slug' => $slug])
							->one();

		$product_id 	= $product->id;
		$cat_id			= $product->category;
		$brand_id 		= $product->brand;

		$category 		= Category::find()
							->where(['id' => $cat_id])
							->one();

		$brand 			= Brand::find()
							->where(['id' => $brand_id])
							->all();

		$listbrand 		= '';
		$countbrand 	= count($brand);
		foreach ( $brand as $key => $brands ) :
			if ( ($key + 1) < $countbrand ) :
				$listbrand 	.= $brands['name'].', ';
			else :
				$listbrand 	.= $brands['name'];
			endif; 
		endforeach;

		$subcategory 	= Subcategory::find()
							->join( 'LEFT JOIN', 'product_category', 'sub_category.id = product_category.sub_category' )
							->where( ['product_category.product' => $product_id] )
							->all();

		$listsub 		= '';
		$countsub 		= count($subcategory);
		foreach ( $subcategory as $key => $subcategories ) :
			if ( ($key + 1) < $countsub ) :
				$listsub 	.= $subcategories['name'].', ';
			else :
				$listsub 	.= $subcategories['name'];
			endif; 
		endforeach;

		$related 		= Product::find()
							->andWhere(['product.category' => $cat_id])
							->andWhere(['not like', 'product.id', $product_id])
							->all();

		if ( !$product )
		{
			throw new \yii\web\NotFoundHttpException();
		}

		return $this->render('index', [
			'product' 		=> $product, 
			'category'		=> $category,
			'brand'			=> $listbrand,
			'subcategory'	=> $subcategory,
			'related' 		=> $related,
		]);

	}
}