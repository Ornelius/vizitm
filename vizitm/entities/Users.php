<?php
namespace vizitm\entities;

use Yii;
use yii\base\Exception;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\db\ActiveQuery;

/**
 * User model
 *
 * @property int        $id
 * @property string     $username
 * @property string     $password_hash
 * @property string     $password_reset_token
 * @property string     $verification_token
 * @property string     $email
 * @property string     $name
 * @property string     $lastname
 * @property int        $position
 * @property string     $auth_key
 * @property int        $status
 * @property int        $created_at
 * @property int        $updated_at
 * @property-read ActiveQuery $profile
 * @property-read string $authKey
 * @property string $password write-only password
 */
class Users extends ActiveRecord implements IdentityInterface
{

    public function attributeLabels(): array
    {
        return [
            'username'          => 'Имя пользователя',
            'email'             => 'Ваш электронный адрес (e-mail)',
            'password'          => 'Пароль',
            'name'              => 'Имя сотрудника',
            'lastname'          => 'Фамлия сотрудника',
            'position'          => 'Должность сотрудника',
            'status'            => 'Статус'
        ];
    }


    const POSITION_ADMINISTRATOR    = 0;
    const POSITION_TEPLOTEHNIK      = 1;
    const POSITION_INGENER          = 2;
    const POSITION_GL_INGENER       = 3;
    const POSITION_KIP              = 4;
    const POSITION_UCHETCHIK        = 5;
    const POSITION_DEGURNI_OPERATOR = 6;




    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    public static function signup(string $username, string $email, string $password): self
    {
        $user = new static();
        $user->username                 = $username;
        $user->email                    = $email;
        $user->setPassword($password);
        $user->created_at               = time();
        $user->status                   = self::STATUS_ACTIVE;
        $user->generateAuthKey();

        return $user;
    }

    public function edit(string $username, string $email, string $password, $status): void
    {
        $this->username                 = $username;
        $this->email                    = $email;
        $this->setPassword($password);
        $this->updated_at               = time();
        $this->status                   = $status;

    }

    public function editProfile(string $name, string $lastname, $position): void
    {
        $this->name                         = $name;
        $this->lastname                     = $lastname;
        $this->position                     = $position;

    }



    /**
     * Function isActive
     */
    public function isActive():bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }


    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%users}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public static function getFullName(int $id): string
    {
        return static::find()->where(['id' => $id, 'status' => self::STATUS_ACTIVE])->one()->name . ' ' .
            static::find()->where(['id' => $id, 'status' => self::STATUS_ACTIVE])->one()->lastname;

    }

    /**
     * Finds user by username
     *
     * @param string $username
     *
     */
    public static function findByUsername(string $username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findUserByID(int $id)
    {
        return static::find()->where(['id' => $id, 'status' => self::STATUS_ACTIVE])->one();
    }
    public static function findEmailByID(int $id): string
    {
        return static::find()->where(['id' => $id, 'status' => self::STATUS_ACTIVE])->one()->email;
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken(string $token): ?Users
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken(string $token): ?Users
    {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     *
     */
    public static function isPasswordResetTokenValid(string $token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey(): ?string
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
     * @throws Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     * @throws Exception
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     * @throws Exception
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     * @throws Exception
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function statusInactive()
    {
        $this->status = self::STATUS_INACTIVE;
    }
    public function statusActive()
    {
        $this->status = self::STATUS_ACTIVE;
    }

    public function getProfile(): ActiveQuery
    {
        return $this->hasOne(Profile::class, ['user_id' =>'id']);
    }


}
