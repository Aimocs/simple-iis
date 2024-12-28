<?php

namespace Aimocs\Iis\Form\Course;

use Aimocs\Iis\Entity\Course;
use Aimocs\Iis\Repo\CategoryRepo;
use Aimocs\Iis\Repo\CourseMapper;

class CourseForm
{

    private string $courseName;

    private string $description;
    private string $courseDuration;
    private float $coursePrice;
    private int $categoryId;

    private array $errors = [];

    public function __construct(
        private CourseMapper $courseMapper,
        private CategoryRepo $categoryRepo
        
    )
    {
    }

    public function setFields(string $courseName,string $description, string $courseDuration, float $coursePrice, int $categoryId): void
    {
        $this->courseName = $courseName;
        $this->description = $description;
        $this->courseDuration = $courseDuration;
        $this->coursePrice = $coursePrice;
        $this->categoryId = $categoryId;
    }


    public function save(): Course
    {

        $course = Course::create(
            $this->courseName,
            $this->description,
            $this->coursePrice,
            $this->categoryRepo->findById($this->categoryId),
            $this->courseDuration
        );
        $this->courseMapper->save($course);
        return $course;
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

        // Validate course name
        if (strlen($this->courseName) < 3 || strlen($this->courseName) > 100) {
            $this->errors[] = 'Course name must be between 3 and 100 characters';
        }

        // Validate course duration
        if (strlen($this->courseDuration) < 3 || strlen($this->courseDuration) > 50) {
            $this->errors[] = 'Course duration must be between 3 and 50 characters';
        }

        // Validate course price
        if ($this->coursePrice <= 0) {
            $this->errors[] = 'Course price must be a positive number';
        }

        // Validate category ID (must be a positive integer)
        if ($this->categoryId <= 0) {
            $this->errors[] = 'Please select a valid category';
        }

        return $this->errors;
    }
}