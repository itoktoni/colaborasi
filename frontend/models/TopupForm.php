<?php

namespace frontend\models;

use YII;
use common\models\base\Topup;
use common\models\base\Member;

/**
 * Signup form.
 */
class TopupForm extends Topup
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['amount', 'required'],
            ['amount', 'number'],
        ];
    }

    /**
     * beforeSave ftw.
     *
     * @param [type] $insert
     */
    public function beforeSave($insert)
    {
        $this->member = YII::$app->user->identity->id;
        $this->expire_at = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')) + 60 * 60);
        $this->status = 1;

        if ($this->member) {
            $list = Member::find()->where(['id' => $this->member])->one();
            $list->balance += $this->amount;
            $list->save(false);
        }

        return parent::beforeSave($insert);
    }
}
