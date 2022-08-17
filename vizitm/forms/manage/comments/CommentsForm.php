<?php
namespace vizitm\forms\manage\comments;
use yii\base\Model;

class CommentsForm extends Model
{
    public $comment;


    public function attributeLabels(): array
    {
        return [
            'comment'           => 'Комментарий',
        ];
    }

    /**
     *!!!!!!!!!!!!!!! {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['comment'], 'string'],
            [['comment'], 'trim'],
        ];
    }

}