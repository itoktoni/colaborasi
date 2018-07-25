<?php

namespace frontend\models;

use yii\base\Model;

/**
 * Signup form.
 */
class TopupForm extends Model
{
    public $amount;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['amount', 'required'],
        ];
    }
}
