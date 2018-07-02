<?php

namespace common\models\base;

use Yii;

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
class Member extends \yii\db\ActiveRecord
{
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
            [['email'], 'required'],
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
}
