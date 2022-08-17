<?php


class Comments extends \yii\base\Model
{
    public ?string $comments;


    public function attributeLabels(): array
    {
        return [
            'comments'           => 'Комментарий',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['comments'], 'string'],
        ];
    }

}