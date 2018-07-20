<?php 
namespace frontend\controllers;
use Yii;

use common\models\base\Category;
use common\models\base\Subcategory;
use common\models\base\Product;
use common\models\base\ProductContent;
use common\models\base\Productlove;
use common\models\base\Brand;
use common\models\search\ProductReviewSearch;
use frontend\components\CMS;
use yii\base\ErrorException;


class ProductController extends \yii\web\Controller
{
	public $member;
	public function init() {
		parent::init();
		$this->view->params['menu'] = 'shop';
		Category::find()->orderBy(['name' => SORT_ASC]);
	}

	public function actionIndex( $slug = false )
	{
		$request = Yii::$app->request;
		if (YII::$app->user->isGuest) {
			$this->member = "";
		}
		else{
			$this->member = YII::$app->user->id;
		}

		if ($request->isAjax) {

			if (YII::$app->user->isGuest) {
				return 'error';
			}

			$product = yii::$app->request->post('product');
            $value = yii::$app->request->post('value');

			$update = Productlove::find()->where(['member' => $this->member, 'product' => $product])->one();
			
			if(empty($update)){
				$save = new Productlove();
				$save->member = $this->member;
				$save->product = $product;
				$save->status = 1;
				$save->save();
				return 1;
			}
            if ($value == "0") {
                 	$update->status = 1;
                	$update->save();
                return 1;
            } else {
                	$update->status = 0;
                	$update->save();
                return 0;
            }
		}
		
		if( !$slug )
		{
			throw new \yii\web\NotFoundHttpException();
		}

		$product 		= Product::find()
							->where(['`product`.slug' => $slug])
							->one();
		if(empty($product)){

			throw new \yii\web\NotFoundHttpException();
		}	
		
		$product->product_view += 1;
		$product->save(false);

		$product_id 	= $product->id;
		$cat_id			= $product->category;
		$brand_id 		= $product->brand;

		$counter = empty($product->product_view) ? 0 : $product->product_view;
		$product->product_view = $counter + 1;
		$product->save();

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

		$related  = Product::find()
							->andWhere(['product.category' => $cat_id])
							->andWhere(['not like', 'product.id', $product_id])
							->all();

		$content = ProductContent::find()->where(['product' => $product_id])->all();
		$review = ProductReviewSearch::find()->where(['product' => $product_id]);
		$love = Productlove::find()->where(['member' => $this->member, 'product' => $product_id])->one();

		return $this->render('index', [
			'product' 		=> $product, 
			'category'		=> $category,
			'brand'			=> $listbrand,
			'subcategory'	=> $subcategory,
			'related' 		=> $related,
			'love' 			=> $love,
			'review'		=> $review,
			'content'		=> $content
		]);

	}

	public function actionComment(){
		$model = new ProductReviewSearch;

		if(YII::$app->request->post() && !YII::$app->user->isGuest)
		{
			
			if(!$model->load(YII::$app->request->post(),'')){
				Yii::$app->session->setFlash('error', "Please fill the form properly");
				$this->redirect(Yii::$app->request->referrer);
				return;
			}
			
			if(!$model->check()){
				Yii::$app->session->setFlash('error', "You already submit review");
				$this->redirect(Yii::$app->request->referrer);
				return;
			}

			$model->member = YII::$app->user->id;
			$model->status = 1;
			$model->save();

			Yii::$app->session->setFlash('success', "Review submited, please wait for our team to review it");
			$this->redirect(Yii::$app->request->referrer);
		}
		elseif(YII::$app->user->isGuest)
		{
			Yii::$app->session->setFlash('error', "Please login first");
			$this->redirect('/login');
		}else{
			Yii::$app->session->setFlash('error', "You can't access this page directly");
			$this->redirect('/');
		}
	}
}