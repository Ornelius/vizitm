<?php
namespace vizitm\forms\manage\request;
use yii\base\Model;
use yii\web\UploadedFile;



class PhotoCreateForm extends Model
{
    /**
     * @var UploadedFile[] files
     */
    public $files;



    public function attributeLabels(): array
    {
        return [
            'building_id'           => 'Адрес объекта недвижимости',
            'description'           => 'Описание проблемы',
            'type'                  => 'Тип заявки',
            'type_of_work'          => 'Тип работы',
            'room'                  => 'Тип помещения',
            'importance'            => 'Срочность'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['files'], 'file', 'skipOnEmpty' => false, 'maxFiles' => 15, 'on' => ['insert', 'update'], 'extensions' => ['png', 'jpg', 'avi', 'mp4']],
        ];
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {

            $this->files = UploadedFile::getInstances($this, 'files');
            return true;
        }
        return false;
    }



}