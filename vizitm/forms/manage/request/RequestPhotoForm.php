<?php


namespace vizitm\forms\manage\request;


use yii\base\Model;

class RequestPhotoForm extends Model
{
    private ?RequestCreateForm $request_        = null;
    private ?PhotoCreateForm $photo_            = null;

    public function __construct($config = [])
    {
        $this->request_ = new RequestCreateForm();
        $this->photo_   = new PhotoCreateForm();

        parent::__construct($config);
    }


    public function rules(): array
    {
        return [
            [['request_', 'photo_'], 'required'],
        ];
    }

    public function getRequest(): ?RequestCreateForm
    {
        return $this->request_;
    }

    public function getPhoto(): ?PhotoCreateForm
    {
        return $this->photo_;
    }


}