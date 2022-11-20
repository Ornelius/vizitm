<?php


namespace vizitm\forms\manage\request;
use vizitm\forms\manage\comments\CommentsForm;
use yii\base\Model;


/**
 *
 * @property-read CommentsForm $comment
 */
class StaffForm extends Model
{

    public                  $direct_to;
    private ?CommentsForm $_comments = null;

    public function __construct($config = [])
    {

        $this->_comments = new CommentsForm();
        parent::__construct($config);
    }


    public function attributeLabels(): array
    {
        return [
            'direct_to'              => 'Назначить сотрудника',
            'comment'                => 'Комментарий',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['direct_to'], 'required'],
            [['direct_to'], 'integer'],
        ];
    }

    public function getComment(): CommentsForm
    {
        return $this->_comments;
    }

}