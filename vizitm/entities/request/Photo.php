<?php

namespace vizitm\entities\request;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;


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
 * @mixin ImageUploadBehavior
 */
class Photo extends ActiveRecord
{
    //Type of Photo
    const PHOTO_OF_PROBLEM              = 1;
    const PHOTO_OF_INVOCE               = 2;
    const PHOTO_OF_PROBLEM_DONE         = 3;
    //Status of Photo
    const TYPE_IMG                      = 4;
    const TYPE_PDF                      = 5;
    const TYPE_VIDEO                    = 6;


    public static function create(UploadedFile $path, int $request_id, int $type, int $sort): self //int $request_id, string $path, int $type): self
    {
        $photo = new static();

        $photo->request_id                      = $request_id;
        $photo->path                            = $path;
        $photo->sort                            = $sort;
        $photo->type                            = $type;
        //$photo->imageFiles                      = $imageFiles;
        //print_r($photo->path); die();
        return $photo;
    }



    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%photo}}';
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
    public function setThumbsOnSave(bool $bool): void
    {
        $this->createThumbsOnSave = $bool;
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

    public function setSort($sort): void
    {
        $this->sort = $sort;
    }


    public function behaviors(): array
    {
        return [
            [
                'class' => ImageUploadBehavior::class,
                'thumbs' => [
                    'thumb' => ['width' => 100, 'height' => 70],
                ],
                'attribute' => 'path',
                'createThumbsOnRequest' => true,
                'filePath' => '/var/www/vizitm/common/uploads/request/origion/[[attribute_request_id]]/[[id]].[[extension]]',
                'fileUrl' => '@web/uploads/request/origion/[[attribute_request_id]]/[[id]].[[extension]]',
                'thumbPath' => '/var/www/vizitm/common/uploads/request/cache/[[attribute_request_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@web/uploads/request/cache/[[attribute_request_id]]/[[profile]]_[[id]].[[extension]]',
            ],
        ];
    }

}
