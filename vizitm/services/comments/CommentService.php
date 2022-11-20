<?php
namespace vizitm\services\comments;



use vizitm\entities\comments\Comments;
use vizitm\forms\manage\comments\CommentsForm;
use vizitm\repositories\CommentRepository;
use Yii;

class CommentService
{
    private CommentRepository $repository;

    public function __construct(CommentRepository $repository )
    {
        $this->repository = $repository;
    }

    public function createComment($request_id, $user_id, CommentsForm $form): void
    {

        $comment = Comments::create(
            $request_id,
            $user_id,
            $form->comment
        );

        $this->repository->save($comment);



    }

}