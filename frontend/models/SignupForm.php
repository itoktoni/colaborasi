<?php
namespace frontend\models;

use yii\base\Model;
use common\models\base\Member;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $name;
    public $email;
    public $password;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            ['name', 'required'],
           
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\base\Member', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        // d(\Yii::$app->request->post());
        
        $user = new Member();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = md5($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}
