<?php

namespace vizitm\entities\request;
use vizitm\entities\Users;
use vizitm\entities\building\Building;
use vizitm\forms\manage\request\RequestEditForm;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%request}}".
 *
 * @property int $id
 * @property int $building_id               Адрес объекта недвижимости
 * @property int $user_id
 * @property string $description            Описание проблемы в заявке
 * @property int $created_at                Дата создания
 * @property int|null $type                 Тип заявки (Оборудование или работа)
 * @property int|null $room                 Тип помещения
 * @property int|null $deleted              Удалена
 * @property int|null $deleted_at           Дата удаления
 * @property int|null $done                 Заявка выполнена
 * @property int|null $done_at              Дата выполнения
 * @property int|null $invoice              Счет на оплату оборудования (работ)
 * @property int|null $invoce_at            Дата выставления счета
 * @property int|null $type_of_work         Тип работы (Замене задвижки, вибровставки)
 * @property int|null $status               Статус заявки (Новая, в работе, выполнена)
 * @property string|null $description_done  Описание выполненной работы
 * @property int|null $public               Тригер публичного доступа
 * @property int|null $importance           Степень важности заявки
 * @property int|null $due_date             Дата выполнения заявки
 * @property int|null $work_whom            Выполняется сотрудником
 *
 * @property Direct $direct                 Должностные лица кому заявка перенаправлена
 * @property Photo[] $photo                 Фотографии проблемы
 * @property Building $building             Адрес объекта недвижимости
 * @property-read ActiveQuery $video
 * @property Users $user
 *
 */
class Request extends ActiveRecord
{

    const STATUS_NEW            = 1;
    const STATUS_WORK           = 2;
    const STATUS_DONE           = 3;
    const STATUS_DUE            = 4;
    const STATUS_DUE_WORK       = 5;

    const STATUS = [
        'new'       => self::STATUS_NEW,
        'work'      => self::STATUS_WORK,
        'done'      => self::STATUS_DONE,
        'due'       => self::STATUS_DUE,
        'duework'   => self::STATUS_DUE_WORK
    ];
    /**
     *
     * @return bool
     */

    public function isNew(): bool
    {
        return $this->status === self::STATUS_NEW;
    }

    public function isWork(): bool
    {
        return $this->status === self::STATUS_WORK;
    }

    public function isDone(): bool
    {
        return $this->status === self::STATUS_DONE;
    }

    public function isDue(): bool
    {
        return $this->status === self::STATUS_DUE;
    }

    public function isDueWork(): bool
    {
        return $this->status === self::STATUS_DUE_WORK;
    }

    public static function create(
        int $building_id,
        string $description,
        int $type,
        int $room,
        int $type_of_work = null,
        ///int $importance = null,
        int $due_date = null
    ): self
    {
        $request = new static();

        $request->building_id               = $building_id;
        $request->user_id                   = Yii::$app->user->identity->getId();
        $request->description               = $description;
        $request->created_at                = time()+4*60*60;
        $request->type                      = $type;
        $request->type_of_work              = $type_of_work;
        $request->status                    = self::STATUS_NEW;
        $request->room                      = $room;
        $request->due_date                  = !empty($due_date) ? $due_date + 17*60*60 : $due_date;
        if(!empty($due_date))
            $request->status                = self::STATUS_DUE;

        return $request;
    }

    public function done(string $description): void
    {
        $this->description_done = $description;
        $this->done_at          = time()+4*60*60;
        $this->done             = true;
        $this->status           = self::STATUS_DONE;
    }

    public function edit( RequestEditForm $form): void
    {
        $this->building_id                  = $form->building_id;
        $this->description                  = $form->description;
        $this->type                         = $form->type;
        $this->type_of_work                 = $form->type_of_work;
        $this->room                         = $form->room;
        //$this->importance                   = $form->importance;
        //$this->due_date                     = $form->due_date;

    }

    public function work(int $staff)
    {
        $this->work_whom        = $staff;
        $this->status           = self::STATUS_WORK;
        if($this->due_date !== null)
            $this->status       = self::STATUS_DUE_WORK;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%request}}';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id'                    => '№',
            'building_id'           => 'Адрес',
            'user_id'               => 'Инициатор',
            'description'           => 'Проблема',
            'created_at'            => 'Дата создания',
            'type'                  => 'Тип заявки',
            'deleted'               => 'Deleted',
            'deleted_at'            => 'Deleted At',
            'done'                  => 'Done',
            'done_at'               => 'Дата выполнения',
            'invoice'               => 'Invoice',
            'invoce_at'             => 'Invoce At',
            'description_done'      => 'Description Done',
            'status'                => 'Статус',
            'due_date'              => 'Дата исполнения',
            'room'                  => 'Помещение',
            'work_whom'             => 'Выполняется сотрудником'
        ];
    }

    /**
     * Gets query for [[Direct]].
     *
     * @return ActiveQuery
     */
    public function getDirect(): ActiveQuery
    {
        return $this->hasMany(Direct::class, ['request_id' => 'id']);
    }

    /**
     * Gets query for [[Photo]].
     *
     * @return ActiveQuery
     */

    public function getPhoto(): ActiveQuery
    {
        return $this->hasMany(Photo::class, ['request_id' => 'id']);
    }
    /**
     * Gets query for [[Video]].
     *
     * @return ActiveQuery
     */

    public function getVideo(): ActiveQuery
    {
        return $this->hasMany(Video::class, ['request_id' => 'id']);
    }

    /**
     * Gets query for [[Building]].
     *
     * @return ActiveQuery
     */
    public function getBuilding(): ActiveQuery
    {
        return $this->hasOne(Building::class, ['id' => 'building_id']);
    }

    /**
     * Gets query for [[User]].
     *     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    public function addPhoto(UploadedFile $file, int $request, int $typeOfPhoto, int $sortOfFile): Photo
    {
        return Photo::create($file, $request, $typeOfPhoto, $sortOfFile);
    }

    public static function listOfRequestNotDoneByUser(int $user_id): array
    {
        return self::find()->andWhere(['user_id' => $user_id])->andWhere(['done' => null])->all();
    }

}
