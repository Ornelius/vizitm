<?php


namespace vizitm\forms\manage\request;


use vizitm\forms\CompositeForm;

class RequestDoneForm extends CompositeForm
{
    private ?RequestUpdateForm $request_           = null;
    private ?PhotoCreateForm    $photo_            = null;

    public function __construct($config = [])
    {
        $this->request_ = new RequestUpdateForm();
        $this->photo_   = new PhotoCreateForm();

        parent::__construct($config);
    }


    public function rules(): array
    {
        return [
            [['request_', 'photo_'], 'required'],
        ];
    }

    public function getRequest(): ?RequestUpdateForm
    {
        return $this->request_;
    }

    public function getPhoto(): ?PhotoCreateForm
    {
        return $this->photo_;
    }

}