<?php

namespace Aimocs\Iis\Form\Group;

use Aimocs\Iis\Entity\Group;
use Aimocs\Iis\Repo\CourseRepo;
use Aimocs\Iis\Repo\EmployeeRepo;
use Aimocs\Iis\Repo\GroupMapper;

class GroupForm
{

    private string $name;
    private int $course_id;
    private int $teacher_id;
    private \DateTimeImmutable $start_datetime;
    private ?int $capacity;
    private array $errors = [];

    public function __construct(private GroupMapper $groupMapper, private CourseRepo $courseRepo, private EmployeeRepo $teacherRepo)
    {
    }

    public function setFields(
        string             $name,
        int                $course_id,
        int                $teacher_id,
        \DateTimeImmutable $start_datetime,
        ?int               $capacity = null
    ): void
    {
        $this->name = $name;
        $this->course_id = $course_id;
        $this->teacher_id = $teacher_id;
        $this->start_datetime = $start_datetime;
        $this->capacity = $capacity;
    }

    public function edit(int $id):Group
    {
        $course = $this->courseRepo->findById($this->course_id);
        $teacher = $this->teacherRepo->findById($this->teacher_id);
        $group = Group::create(
            $this->name,
            $course,
            $teacher,
            $this->start_datetime,
            $this->capacity,
            $id
        );
        $this->groupMapper->edit($group);
        return $group;

    }
    public function save():Group
    {
        $course = $this->courseRepo->findById($this->course_id);
        $teacher = $this->teacherRepo->findById($this->teacher_id);
        $group = Group::create(
            $this->name,
            $course,
            $teacher,
            $this->start_datetime,
            $this->capacity
        );
        $this->groupMapper->save($group);
        return $group;
    }

    public function hasValidationErrors(): bool
    {
        return count($this->getValidationErrors()) > 0;
    }

    public function getValidationErrors(): array
    {
        if (!empty($this->errors)) {
            return $this->errors;
        }

        // Validate name
        if (empty($this->name)) {
            $this->errors[] = 'Name cannot be empty';
        }

        // Validate start_datetime (example: must not be in the past)
        if ($this->start_datetime < new \DateTimeImmutable()) {
            $this->errors[] = 'Start date and time must not be in the past';
        }

        // Validate capacity (if set, it must be a positive integer)
        if (!is_null($this->capacity) && $this->capacity <= 0) {
            $this->errors[] = 'Capacity must be a positive integer';
        }

        return $this->errors;
    }
}