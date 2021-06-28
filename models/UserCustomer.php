<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $email
 * @property string $username
 * @property string $password
 * @property string|null $authKey
 * @property string|null $address
 * @property int|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class UserCustomer extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface {
    const SCENARIO_LOGIN = 'login';
    const SCENARIO_REGISTER = 'register';

    private $_user = false;
    
    public static function tableName() {
        return 'users';
    }

    public function rules() {
        // return array(
        //     UtilValidation::required('username'),
        //     UtilValidation::length('username', max:4),
        // )''
        return [
            [['email', 'username', 'password'], 'required', 'on' => self::SCENARIO_REGISTER],
            [['email', 'password'], 'required', 'on' => self::SCENARIO_LOGIN],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['email', 'username', 'password', 'authKey', 'address'], 'string', 'max' => 255],
            [['username'], 'unique', 'on' => self::SCENARIO_REGISTER],
            [['email'], 'unique', 'on' => self::SCENARIO_REGISTER],
            [['email'], 'email'],
            ['email', 'validateEmail', 'on' => self::SCENARIO_LOGIN],
            ['password', 'validatePassword', 'on' => self::SCENARIO_LOGIN],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'username' => 'Username',
            'password' => 'Password',
            'authKey' => 'Auth Key',
            'address' => 'Address',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getId() {
        return $this->id;
    }

    public function getAuthKey() {
        return $this->authKey;
    }

    public function validateAuthKey($authKey) {
        return $this->authKey === $authKey;
    }

    public static function findIdentity($id) {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        throw new yii\base\NotSupportedException();
    }

    public function validateEmail($attribute, $params) {
        $user = self::findOne(['email' => $this->email]);
        if(!$user) {
            $this->addError($attribute, 'Email does not exist !');
        } else {
            $this->_user = $user;
        }
    }

    public function validatePassword($attribute, $params) {
        if (!$this->_user === false) {
            if (!Yii::$app->getSecurity()->validatePassword($this->password, $this->_user->password)) {
                $this->addError($attribute, 'Incorrect password !');
            }
        }
    }

    public function login() {
        if ($this->validate()) {
            return Yii::$app->user->login($this->_user);
        }
        return false;
    }
}
