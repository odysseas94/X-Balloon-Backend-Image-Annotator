<?php

namespace app\models\pure;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $firstname
 * @property string $lastname
 * @property int $user_type_id
 * @property int $gender_id
 * @property string $phone
 * @property string $city
 * @property string $address
 * @property string $token
 * @property int $country_id
 * @property int $image_id
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property int $status
 * @property string $date_created
 * @property string $date_updated
 * @property string|null $verification_token
 *
 * @property ImageCreator[] $imageCreators
 * @property Image[] $images
 * @property Country $country
 * @property Gender $gender
 * @property UserType $userType
 * @property UserManager[] $userManagers
 * @property UserManager[] $userManagers0
 * @property User[] $users
 * @property User[] $managers
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{

    public const STATUS_DELETED = 0;
    public const STATUS_INACTIVE = 9;
    public const STATUS_ACTIVE = 10;

    public $password;
    public $password_repeat;
    public $image_upload;
    const SCENARIOCREATE = 'create';
    const SCENARIOUPDATE = 'update';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }


    public function getScenarios()
    {

        return [
            self::SCENARIOCREATE => ['username', 'firstname', 'lastname', 'user_type_id', 'gender_id', 'token', 'country_id', "phone", 'auth_key', "password", "password_repeat", "image_id", 'password_hash', 'email'],
            self::SCENARIOUPDATE => ['username', 'firstname', 'lastname', 'user_type_id', 'gender_id', 'token', 'country_id', "phone", 'email'],
        ];
    }

    public function rules()
    {

        $scenarios = $this->getScenarios();
        return [
            [$scenarios[self::SCENARIOCREATE], 'required', 'on' => self::SCENARIOCREATE],
            [$scenarios[self::SCENARIOUPDATE], 'required', 'on' => self::SCENARIOUPDATE],
            [['gender_id', 'user_type_id', 'country_id', 'status','image_id'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'password', 'email', 'verification_token'], 'string', 'max' => 255],
            [['firstname', 'lastname', 'city', 'address'], 'string', 'max' => 64],
            [['token'], 'string', 'max' => 127],
            [['phone'], 'string', 'max' => 15],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['token'], 'unique'],
            [['date_created', 'date_updated', 'date_born'], 'safe'],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            [['password_reset_token'], 'unique'],
            [['phone'], 'match', 'pattern' => '/^\+?1?\s*?\(?\d{3}(?:\)|[-|\s])?\s*?\d{3}[-|\s]?\d{4}$/'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match"],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
            [['gender_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gender::className(), 'targetAttribute' => ['gender_id' => 'id']],
            [['user_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserType::className(), 'targetAttribute' => ['user_type_id' => 'id']],
        ];
    }


    public function getIsAdmin()
    {

        return $this->userType->name === "admin";

    }


    public function getIsManager()
    {
        return $this->userType->name === "manager";
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'firstname' => Yii::t('app', 'Firstname'),
            'lastname' => Yii::t('app', 'Lastname'),
            'gender_id' => Yii::t('app', 'Gender'),
            'user_type_id' => Yii::t('app', 'User Type'),
            'token' => Yii::t('app', 'Token'),
            'country_id' => Yii::t('app', 'Country'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'phone' => Yii::t('app', 'Phone'),
            'image_id' => Yii::t('app', 'Image'),
            'city' => Yii::t('app', 'City'),
            'address' => Yii::t('app', 'Address'),
            'date_born' => Yii::t('app', 'Date Born'),
            'password' => Yii::t('app', 'Password'),
            'password_repeat' => Yii::t('app', 'Password Repeat'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'email' => Yii::t('app', 'Email'),
            'status' => Yii::t('app', 'Status'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_updated' => Yii::t('app', 'Date Updated'),
            'verification_token' => Yii::t('app', 'Verification Token'),
        ];
    }

    public function getImagePath()
    {
        if ($this->image)
            return $this->image;
        return null;
    }

    public function newImagePath()
    {

        if ($this->image_upload && $this->image_upload instanceof \yii\web\UploadedFile)
            return "upload/user/" . strtotime("now") . rand() . "." . $this->image_upload->extension;
        return null;
    }

    public function getFullname()
    {
        return $this->firstname . " " . $this->lastname;
    }

    public function getImageCreators()
    {
        return $this->hasMany(ImageCreator::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Images]].
     *
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getImages()
    {
        return $this->hasMany(Image::className(), ['id' => 'image_id'])->viaTable('image_creator', ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Country]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }


    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }

    /**
     * Gets query for [[Gender]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGender()
    {
        return $this->hasOne(Gender::className(), ['id' => 'gender_id']);
    }

    /**
     * Gets query for [[UserType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserType()
    {
        return $this->hasOne(UserType::className(), ['id' => 'user_type_id']);
    }

    /**
     * Gets query for [[UserManagers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserManagers()
    {
        return $this->hasMany(UserManager::className(), ['manager_id' => 'id']);
    }

    /**
     * Gets query for [[UserManagers0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserManagers0()
    {
        return $this->hasMany(UserManager::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('user_manager', ['manager_id' => 'id']);
    }

    /**
     * Gets query for [[Managers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getManagers()
    {
        return $this->hasMany(User::className(), ['id' => 'manager_id'])->viaTable('user_manager', ['user_id' => 'id']);
    }


    public function login()
    {

        return Yii::$app->user->login($this, 3600 * 24 * 30);
        if ($this->validate()) {

            return Yii::$app->user->login($this, 3600 * 24 * 30);
        }
        return false;
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
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
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
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
    public static function findByVerificationToken($token)
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
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
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
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

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


    public static function getRestricted($user_id)
    {
        $manager_id = Yii::$app->user->identity->id;
        if (Yii::$app->user->identity->isAdmin)

            return self::find()->all();
        else if (Yii::$app->user->identity->isManager)
            return self::findBySql("select user.* from user where (user.id='$manager_id'
                           or exists (select user_id from user_manager where user.id=user_manager.user_id and manager_id='$manager_id') ) and user.id='$user_id'")->one();
        return [];
    }

    public static function getAllRestricted($user_id = null)
    {
        $user_id = $user_id ? $user_id : $user_id = Yii::$app->user->identity->id;


        if (Yii::$app->user->identity->isAdmin)

            return self::find()->all();
        else if (Yii::$app->user->identity->isManager)
            return self::findBySql("select user.* from user where user.id='$user_id'
                           or exists (select user_id from user_manager where user.id=user_manager.user_id and manager_id='$user_id');")->all();
        return [];

    }
    public function imageInstance()
    {

        $image = $this->hasOne(Image::className(), ['id' => 'image_id'])->one();
        if ($image) {


            return $image;
        }


        return new Image();
    }


}
