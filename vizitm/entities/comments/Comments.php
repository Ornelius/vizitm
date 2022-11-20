<?php
namespace vizitm\entities\comments;
use vizitm\entities\request\Request;
use vizitm\entities\Users;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "comments".
 *
 * @property int $id
 * @property int|null $request_id
 * @property int|null $user_id
 * @property string|null $comment
 * @property-read ActiveQuery $user
 * @property-read ActiveQuery $request
 * @property int|null $datetime
 *
 */

class Comments extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%comments}}';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id'                    => 'ID',
            'request_id'            => 'Request ID',
            'user_id'               => 'USer ID',
            'comment'               => 'Комментарий',
            'datetime'              => 'DateTime',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Request]].
     *
     * @return ActiveQuery
     */
    public function getRequest(): ActiveQuery
    {
        return $this->hasOne(Request::class, ['id' => 'request_id']);
    }
    public static function findCommentsByRequestId(int $id): array
    {
        return self::find()->andWhere(['request_id'    => $id])->all();
    }


    public static function create(int $request_id, int $user_id, string $comments): self
    {
        $comment = new static();
        $comment->request_id            = $request_id;
        $comment->user_id               = $user_id;
        $comment->comment               = $comments;
        $comment->datetime              = time()+4*60*60;
        return $comment;
    }

}