<?php
namespace frontend\components;


use Yii;
use yii\helpers\Html;
use common\models\base\Category;
use common\models\base\Subcategory;
use common\models\Brand;

class CMS {

	public static function getCategory(){
        return Category::find()->where(['status' => Category::STATUS_ACTIVE])->orderBy(['name' => SORT_ASC])->limit(3)->all();
    }

    public static function getSubCategory(){
		$subcategory = Subcategory::find()
						->select(['sub_category.*','category_name' => 'category.name', 'category_slug' => 'category.slug'])
						->where(['category.status' => Category::STATUS_ACTIVE, 'sub_category.status' => Category::STATUS_ACTIVE])
						->join('left join','category','category.id=sub_category.category')
						->orderBy(['category.name' => SORT_ASC,'sub_category.name' => SORT_ASC])
						->all();

		// print_r($subcategory); die();

		$return = [];
		foreach($subcategory as $item) :
			$return[$item->category_slug][] = $item;
		endforeach;

		return $return;
	}

}