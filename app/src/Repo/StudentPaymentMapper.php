<?php

namespace Aimocs\Iis\Repo;

use Aimocs\Iis\Entity\StudentPayment;
use Aimocs\Iis\Flat\Database\DataMapper;

class StudentPaymentMapper
{
    private string $table = "payments";

    public function __construct(
        private DataMapper $dataMapper
    )
    {
    }

    public function save(StudentPayment $studentPayment)
    {
        $course_student_id= $studentPayment->courseStudent->getId();
        $amount = $studentPayment->amount;
        $remark = $studentPayment->remark;
        $created_at= ($studentPayment->getCreatedAt())->format('Y-m-d H:i:s');
        $id = $this->dataMapper->getDatabase()->Insert($this->table,["course_student_id"=>$course_student_id,"amount"=>$amount,"remark"=>$remark,"created_at"=>$created_at]);
        $studentPayment->setId($id);

    }
}