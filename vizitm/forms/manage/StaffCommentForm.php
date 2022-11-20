<?php
namespace vizitm\forms\manage;

use vizitm\entities\comments\CommentsForm;
use vizitm\forms\manage\request\StaffForm;
use yii\base\Model;

class StaffCommentForm extends Model
{
    private ?StaffForm $_staff;
    private ?CommentsForm $_comment;

    public function __construct($config = [])
    {
        $this->_staff = new StaffForm();
        $this->_comment = new CommentsForm();

        parent::__construct($config);
    }


    public function getComments()
    {
        $this->_comment;

    }
    public function getStaff()
    {
        $this->_staff;

    }
}