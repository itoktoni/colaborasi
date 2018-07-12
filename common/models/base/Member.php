<?php

namespace common\models\base;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "member".
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $address_optional
 * @property string $email
 * @property string $balance
 * @property string $picture
 * @property int $social_media_type
 * @property string $social_media_id
 * @property string $password
 * @property string $password_reset_token
 * @property string $created_at
 * @property string $updated_at
 * @property int $status
 */
class Member extends \yii\db\ActiveRecord implements IdentityInterface 
{

    public $auth_key;
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    public $password_hash;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'member';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email','status'], 'required'],
            [['balance'], 'number'],
            [['social_media_type', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'address', 'address_optional', 'picture', 'social_media_id', 'password', 'password_reset_token'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 64],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'address' => 'Address',
            'address_optional' => 'Address Optional',
            'email' => 'Email',
            'balance' => 'Balance',
            'picture' => 'Picture',
            'social_media_type' => 'Social Media Type',
            'social_media_id' => 'Social Media ID',
            'password' => 'Password',
            'password_reset_token' => 'Password Reset Token',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

     /**
     * outorization require by social media login
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    // end social media login
    
    //=================================================================================================

    //autorize require by login

    public static function findByUsername($username)
    {
        return static::find()->where(['email' => $username, 'status' => self::STATUS_ACTIVE])->one();
    }

    public function validatePassword($password)
    {
        if (md5($password) == $this->password)
        {
            return true;
        }

        return false;
    }

    // end outorization by login page

    // require for sign up

    public function setPassword($password)
    {
        $this->password_hash = md5($password);
        $this->password = md5($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token))
        {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

      /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token))
        {
            return null;
        }
        
        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => self::STATUS_ACTIVE,
        ]);
    }
 
    


     /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }





    // end sign up
}
