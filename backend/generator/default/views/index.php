<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\helpers\Url;
use backend\models\base\Permission;
use backend\components\CMS;
use backend\components\SearchWidget;
use backend\components\TableWidget;

/* @var $this yii\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?=$generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass))))?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?=Inflector::camel2id(StringHelper::basename($generator->modelClass))?>-index container-fluid">

    <h2><?="<?= "?>Html::encode($this->title) ?></h2>
    <div class="row">
        <div class="col-md-12">
            <?="

                echo SearchWidget::widget(
                    [
                		'action'=> Url::to('/".strtolower(StringHelper::basename($generator->modelClass))."'),
                		'field' =>
                        ['" . StringHelper::basename($generator->modelClass) . "' =>
                            [
                                'name' => 'name',
                                'placeholder' => 'Find " . Inflector::camel2words(StringHelper::basename($generator->modelClass)) . "',
                                'class' => 'form-control',
                            ],
                        ], 'status' => backend\components\CMS::StatusWidget(),
                    ]
                );";
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-icon" data-background-color="purple">
                    <?php if (YII::$app->cms->check_permission(Permission::FULL_ACCESS)): ?>
                    <a href="/user/create" class="" title="" rel="tooltip" data-original-title="Create User">
                        <i class="material-icons">add</i>
                    </a>
                    <?php endif;?>
                </div>
                <div class="card-content">
                    <h4 class="card-title" style="visibility: hidden;">Users</h4>
                    <div class="table-responsive">

                        <?="echo TableWidget::widget([
                            'action' => '" . Inflector::camel2words(StringHelper::basename($generator->modelClass)) . "',
                            'action_url' => '" . strtolower(StringHelper::basename($generator->modelClass)) . "',
                            'data' => " . '$dataProvider' . ",
                            'header' => [";?>
                            <?php 
                            if (($tableSchema = $generator->getTableSchema()) === false) {
                                foreach ($generator->getColumnNames() as $name) {
                                    if($name == 'id'|| $name == 'status'):continue;endif;
                                    echo Inflector::camel2words("'$name',");
                                }
                            } 
                            else {
                                foreach ($tableSchema->columns as $column) {
                                    $format = $generator->generateColumnFormat($column);
                                    if($column->name == 'id'|| $column->name == 'status'):continue;endif;
                                    echo Inflector::camel2words("'$column->name',");
                                }
                        }?>

                        <?="'Status', 'Action'],
                        'field' => [";?>
                        <?php
                        if (($tableSchema = $generator->getTableSchema()) === false) {
                            foreach ($generator->getColumnNames() as $name) {
                                if($name == 'id'|| $name == 'status'):continue;endif;
                                echo "'$name' => '$name',";
                            }
                        } else {
                            foreach ($tableSchema->columns as $column) {
                                $format = $generator->generateColumnFormat($column);
                                if($column->name == 'id' || $column->name == 'status'):continue;endif;
                                echo "'$column->name' => '$column->name',";
                            }
                        }
                        ?>
                            <?="'status' =>
                                ['callback' =>
                                    ['class' => 'backend\components\CMS', 'method' => 'getStatus'],
                                ],
                            ]]);
                        ?>
                        ";?>
                    </div>

                    <?php echo "<?php
                    echo yii\widgets\LinkPager::widget([
                        'pagination' => " . '$pages' . ",
                        'options' => [
                            'class' => 'pagination pull-right',
                        ],
                    ]);
                    ?>";?>

                </div>
            </div>
        </div>
    </div>
</div>

