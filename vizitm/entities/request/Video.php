<?php

namespace vizitm\entities\request;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%photo}}".
 *
 * @property int $id
 * @property int $request_id
 * @property string $path
 * @property int|null $sort
 * @property int|null $type
 *
 * @property Request $request
 */
class Video extends ActiveRecord
{
    const VIDEO_OF_PROBLEM           = 1;
    const PHOTO_OF_INVOCE            = 2;
    const PHOTO_OF_PROBLEM_DONE      = 3;

    public static function create(UploadedFile $path, int $request_id, int $type): self
    {
        $video = new static();

        $video->request_id                      = $request_id;
        $video->path                            = $path;
        return $video;
    }



    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%video}}';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id'            => 'ID',
            'request_id'    => 'Request ID',
            'path'          => 'Path',
            'type'          => 'Type',
        ];
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

}
