<?php

namespace Aimocs\Iis\Repo;

use Aimocs\Iis\Entity\CourseStudent;
use Aimocs\Iis\Entity\StudentPayment;
use Aimocs\Iis\Flat\Database\Database;
use Symfony\Component\VarDumper\Cloner\Data;

class StudentPaymentRepo
{

    private string $table = "payments";
    public function __construct(
        private Database $database,
        private CourseStudentRepo $courseStudentRepo
    )
    {
    }

    public function getPaymentsByStudentId(int $cs_id):?array
    {
        $data =$this->database->SelectByCriteria($this->table,"*","course_student_id",[$cs_id]);
        if (empty($data)){
            return null;
        }
        $payments= [];
        foreach ($data as $payment){
            $course_student = $this->courseStudentRepo->findById($cs_id);
            $payments[]=StudentPayment::create($course_student,$payment->amount,$payment->remark,$payment->id,new \DateTimeImmutable($payment->created_at));
        }
        return $payments;
    }
}

