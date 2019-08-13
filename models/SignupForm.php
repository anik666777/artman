<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $name;
    public $last_name;
    public $password;
    public $confirm_password;
    public $captcha;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'name', 'last_name'], 'required'],
            [['username'], 'trim'],
            [['username'], 'string', 'min' => 2, 'max' => 255],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Этот адрес электронной почты уже занят.'],
            [['username'], 'email'],
            ['password', 'string', 'min' => 6],
            ['password', 'compare', 'compareAttribute'=>'confirm_password', 'message'=>'Подтвердите пароль'],
            ['confirm_password', 'compare', 'compareAttribute'=>'password', 'message'=>'Пароли не совпадают'],
            ['captcha', 'captcha'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels() {
        return [
            'name' => 'Имя',
            'last_name' => 'Фамилия',
            'username' => 'Email',
            'password' => 'Пароль',
            'confirm_password' => 'Подверждение пароля',
            'captcha'=>'Проверочный код',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     * @throws \yii\base\Exception
     */
    public function signup()
    {

        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->name = $this->name;
        $user->last_name = $this->last_name;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        return $user->save() ? $user : null;
    }

}





