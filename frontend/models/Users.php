<?php

namespace frontend\models;

use Yii;
use yii\base\InvalidConfigException;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $user_name
 * @property string $email
 * @property string $password
 * @property string|null $phone
 * @property string|null $skype
 * @property string|null $telegram
 * @property string|null $address
 * @property int|null $city_id
 * @property int|null $role_id
 * @property int $rating
 * @property string $date_of_birth
 * @property string|null $about
 * @property string|null $avatar
 * @property int|null $count_fails
 * @property int|null $count_viewers
 * @property string|null $last_active_time
 * @property string|null $creation_date
 *
 * @property Chat[] $chats
 * @property Chat[] $chats0
 * @property Cities $city
 * @property Favorites[] $favorites
 * @property Favorites[] $favorites0
 * @property Portfolio[] $portfolios
 * @property Respond[] $responds
 * @property Reviews[] $reviews
 * @property Roles $role
 * @property Tasks[] $tasks
 * @property Tasks[] $tasks0
 * @property UserCategory[] $userCategories
 * @property int|string $countReviews
 * @property float $avgRating
 * @property int|string $countTasks
 * @property string $relativeTime
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_name', 'email', 'password', 'date_of_birth'], 'required'],
            [['city_id', 'role_id', 'rating', 'count_fails', 'count_viewers'], 'integer'],
            [['date_of_birth', 'last_active_time', 'creation_date'], 'safe'],
            [['about'], 'string'],
            [['user_name', 'email', 'avatar'], 'string', 'max' => 128],
            [['password'], 'string', 'max' => 64],
            [['phone', 'skype', 'telegram'], 'string', 'max' => 25],
            [['address'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::className(), 'targetAttribute' => ['role_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_name' => 'User Name',
            'email' => 'Email',
            'password' => 'Password',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'telegram' => 'Telegram',
            'address' => 'Address',
            'city_id' => 'City ID',
            'role_id' => 'Role ID',
            'rating' => 'Rating',
            'date_of_birth' => 'Date Of Birth',
            'about' => 'About',
            'avatar' => 'Avatar',
            'count_fails' => 'Count Fails',
            'count_viewers' => 'Count Viewers',
            'last_active_time' => 'Last Active Time',
            'creation_date' => 'Creation Date',
        ];
    }

    /**
     * Gets query for [[Chats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChats()
    {
        return $this->hasMany(Chat::className(), ['sender_id' => 'id']);
    }

    /**
     * Gets query for [[Chats0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChats0()
    {
        return $this->hasMany(Chat::className(), ['recipient_id' => 'id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Favorites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavorites()
    {
        return $this->hasMany(Favorites::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Favorites0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavorites0()
    {
        return $this->hasMany(Favorites::className(), ['favorite_user_id' => 'id']);
    }

    /**
     * Gets query for [[Portfolios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPortfolios()
    {
        return $this->hasMany(Portfolio::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Responds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponds()
    {
        return $this->hasMany(Respond::className(), ['sender_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Roles::className(), ['id' => 'role_id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::className(), ['owner_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks0()
    {
        return $this->hasMany(Tasks::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[UserCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserCategories()
    {
        return $this->hasMany(UserCategory::className(), ['user_id' => 'id']);
    }
    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories() {
        try {
            return $this->hasMany(Categories::class, ['id' => 'category_id'])
                ->viaTable('user_category', ['user_id' => 'id']);
        } catch (InvalidConfigException $e) {
        }
    }
    /**
     * @return int|string
     */
    public function getCountReviews()
    {
        return Reviews::find()->where(['executor_id' => $this->id])->count();
    }
    /**
     * @return false|float
     */
    public function getAvgRating()
    {
        $totalRating = Reviews::find()->where(['executor_id' => $this->id])->sum('rating');
        return empty($this->getCountReviews()) ? 0 : round($totalRating / $this->getCountReviews(), 2);
    }
    /**
     * @return int|string
     */
    public function getCountTasks()
    {
        return Tasks::find()->where(['executor_id' => $this->id])->count();
    }

    /**
     * @return string
     */
    public function getRelativeTime()
    {
        return Yii::$app->formatter->format($this->last_active_time, 'relativeTime');
    }

}
