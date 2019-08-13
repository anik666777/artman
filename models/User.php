<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $name
 * @property string $last_name
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $is_online
 * @property integer $date_created
 * @property integer $date_updated
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DISABLE = 0;
    const STATUS_ACTIVE = 1;

    const IS_OFFLINE = 0;
    const IS_ONLINE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => '\yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['date_created', 'date_updated'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['date_updated'],
                ],
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DISABLE]],
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
            'is_online' => 'Онлайн',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     *
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * @return array
     */
    public function getOnlineLabelList()
    {
        return [
            static::IS_ONLINE => 'Онлайн',
            static::IS_OFFLINE => 'Оффлайн',
        ];
    }

    /**
     * @return int
     */
    public function isOnline()
    {
        return $this->is_online == self::IS_ONLINE;
    }

    /**
     * @return int
     */
    public function isOffline()
    {
        return $this->is_online == self::IS_OFFLINE;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getOnlineLabel()
    {
        return ArrayHelper::getValue($this->getOnlineLabelList(), $this->is_online, 'Оффлайн');
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->name . ' ' . $this->last_name;
    }

    /**
     * @return string
     */
    public function getOnlineIcon()
    {
        return ArrayHelper::getValue([
            self::IS_OFFLINE => '<span class="is-offline">⬤</span>',
            self::IS_ONLINE => '<span class="is-online">⬤</span>',
        ], $this->is_online, '');
    }
}