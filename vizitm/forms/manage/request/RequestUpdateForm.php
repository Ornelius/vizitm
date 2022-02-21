<?php
namespace vizitm\forms\manage\request;
use vizitm\forms\CompositeForm;

/**
 * @property PhotoCreateForm $photo
 */


class RequestUpdateForm extends CompositeForm
{
    public ?string  $done_description    = null;

    public function __construct($config = [])
    {
        $this->photo = new PhotoCreateForm();
        parent::__construct($config);
    }


    public function attributeLabels(): array
    {
        return [
            'done_description'              => 'Описание проблемы',
            'done_at'                       => 'Дата исполнения'
        ];
    }





    /**
     * {@inheritdoc}
     * @var array
     */
    public function rules(): array
    {
        return [
            [['done_description'], 'required'],
            //[['done_description'], 'integer'],
            [['done_description'], 'string'],
        ];
    }


    protected function internalForms(): array
    {
        return ['photo'];
    }
}