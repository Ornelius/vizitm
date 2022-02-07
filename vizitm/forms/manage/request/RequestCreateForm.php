<?php
namespace vizitm\forms\manage\request;
use vizitm\forms\CompositeForm;

/**
 * @property PhotoCreateForm $photo
 */


class RequestCreateForm extends CompositeForm
{
    public ?int     $user_id        = null;
    public ?int     $building_id    = null;
    public ?string  $description    = null;
    public ?int     $type           = null;
    public ?int     $type_of_work   = null;
    public ?int     $room           = null;
    public ?int     $importance     = null;
    public          $due_date       ;

    public function __construct($config = [])
    {
        $this->photo = new PhotoCreateForm();
        parent::__construct($config);
    }


    public function attributeLabels(): array
    {
        return [
            'building_id'           => 'Адрес здания',
            'description'           => 'Описание проблемы',
            'type'                  => 'Тип заявки',
            'type_of_work'          => 'Тип работы',
            'room'                  => 'Тип помещения',
            'importance'            => 'Срочность',
            'due_date'              => 'Дата исполнения'
        ];
    }





    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['building_id', 'description', 'type', 'room'], 'required'],
            [['building_id', 'type', 'room', 'importance'], 'integer'],
            //[['building_id', 'user_id', 'created_at', 'deleted', 'deleted_at', 'done', 'done_at', 'invoice', 'invoce_at', 'type_of_work', 'status'], 'integer'],
            [['description'], 'string'],
            ['due_date', 'default', 'value' => null],
            ['due_date', 'date', 'timestampAttribute' => 'due_date'],
            //[['building_id'], 'unique'],
            //[['user_id'], 'unique'],
            //[['building_id'], 'exist', 'skipOnError' => true, 'targetClass' => Building::class, 'targetAttribute' => ['building_id' => 'id']],
            //[['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
            //[['photo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Photo::class],
        ];
    }


    protected function internalForms(): array
    {
        return ['photo'];
    }
}