<?php
namespace vizitm\forms\manage\request;
use vizitm\entities\request\Request;
use vizitm\forms\CompositeForm;
use yii\base\BaseObject;
use yii\base\Model;

/**
 * @property PhotoCreateForm $photo
 */

class RequestEditForm extends Model
{
    public ?int                 $id             = null;
    public ?int                 $building_id    = null;
    public ?string              $description    = null;
    public ?int                 $type           = null;
    public ?int                 $type_of_work   = null;
    public ?int                 $room           = null;
    //public $importance                   ;
    //public $due_date                     ;
    //public Request $_request ;

    public function __construct(Request $request, $config = [])
    {
        $this->id                           = $request->id;
        $this->building_id                  = $request->building_id;
        $this->description                  = $request->description;
        $this->type                         = $request->type;
        $this->type_of_work                 = $request->type_of_work;
        $this->room                         = $request->room;
        //$this->importance                   = $request->importance;
        //$this->due_date                     = $request->due_date;
        //$this->_request = $request;
        //$this->photo = new PhotoCreateForm();
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

    public function rules(): array
    {
        return [
            [['description'], 'required'],
            ['description', 'string', 'max' => 255],
            [['type', 'type_of_work', 'room', 'building_id'], 'integer'],
        ];
    }

   /* protected function internalForms(): array
    {
        return ['photo'];
    }*/
}