<?php
namespace backend\models\form;

use Yii;
use yii\base\Model;
use backend\models\base\User;

/**
 * Login form
 */
class LoginForm extends Model {

    public $username;
    public $password;
    public $rememberMe = true;
    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
                [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
<<<<<<< HEAD:common/models/LoginForm.php
        if (!$this->hasErrors())
        {
=======

       
        if (!$this->hasErrors()) {
>>>>>>> 3a9c2c813e87f2f07bf7428e0cbe28ad3d4907ff:backend/models/form/LoginForm.php
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password))
            {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
<<<<<<< HEAD:common/models/LoginForm.php
        if ($this->validate())
        {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

=======

        
        if ($this->validate()) {
            
            // d('test');
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
   
        
>>>>>>> 3a9c2c813e87f2f07bf7428e0cbe28ad3d4907ff:backend/models/form/LoginForm.php
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
<<<<<<< HEAD:common/models/LoginForm.php
        if ($this->_user === null)
        {
=======
        
        if ($this->_user === null) {
>>>>>>> 3a9c2c813e87f2f07bf7428e0cbe28ad3d4907ff:backend/models/form/LoginForm.php
            $this->_user = User::findByUsername($this->username);
        }


        return $this->_user;
    }

}
