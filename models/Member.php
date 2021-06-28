<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "members".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $password
 * @property string|null $address
 * @property int|null $age
 */
class Member extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'members';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            [['age'], 'integer'],
            [['name', 'password', 'address'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 50],
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
            'email' => 'Email',
            'password' => 'Password',
            'address' => 'Address',
            'age' => 'Age',
        ];
    }

    // Mối quan hệ
    public function getTasks() {
        return $this->hasMany(Task::class, ['user_id' => 'id']);
        // 1 member có nhiều tasks, user_id là của Task Model 
    }
}
