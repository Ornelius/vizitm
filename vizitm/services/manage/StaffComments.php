<?php


namespace vizitm\services\manage;


use vizitm\forms\manage\StaffCommentForm;

class StaffComments
{
    private $value;

    public function __construct(StaffCommentRepository $value)
    {
        $this->value = $value;
    }

    public function create(StaffCommentForm $form)
    {
        $product = Stu::create(
            $form->code,
            $form->name,
            new Meta(
                $form->meta->title,
                $form->meta->description
            )
        );

        $product->changePrice($form->price->new, $form->price->old);

        foreach ($form->values as $valueForm) {
            $product->changeValue($valueForm->getCharacteristicId(), $valueForm->value);
        }

        $this->products->save($product);
        return $product->id;
    }

}