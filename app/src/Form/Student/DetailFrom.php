<?php

namespace Aimocs\Iis\Form\Student;

use Aimocs\Iis\Entity\Student;
use Aimocs\Iis\Repo\StudentMapper;

class DetailFrom
{
    private string $name;
    private int $age;
    private string $gender;
    private string $email;
    private string $phone;
    private string $address;
    private string $level;

    private array $errors = [];

    public function __construct(private StudentMapper $studentMapper)
    {
    }

    public function setFields(
        string $name,
        int    $age,
        string $gender,
        string $email,
        string $phone,
        string $address,
        string $level
    ): void
    {
        $this->name = $name;
        $this->age = $age;
        $this->gender = $gender;
        $this->email = $email;
        $this->phone = $phone;
        $this->address = $address;
        $this->level = $level;
    }

    public function edit(int $id): Student
    {

        $student = Student::create(
            $this->name,
            $this->age,
            $this->gender,
            $this->phone,
            $this->email,
            $this->address,
            $this->level,
            $id
        );

        $this->studentMapper->edit($student);
        return $student;

    }
    public function save(): Student
    {
        $student = Student::create($this->name, $this->age, $this->gender, $this->phone,$this->email, $this->address, $this->level);

        $this->studentMapper->save($student);

        return $student;
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
        if (strlen($this->name) < 3 || strlen($this->name) > 50) {
            $this->errors[] = 'Name must be between 3 and 50 characters';
        }

        // Validate age
        if ($this->age < 1 || $this->age > 120) {
            $this->errors[] = 'Age must be a valid number between 1 and 120';
        }

        // Validate gender
        if (!in_array($this->gender, ['male', 'female', 'other'], true)) {
            $this->errors[] = 'Gender must be one of male, female, or other';
        }

        // Validate email
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = 'Invalid email address';
        }
        // Check for invalid characters (anything except digits, spaces, hyphens, parentheses, or "+")
        if (preg_match('/[^0-9\s\-\(\)\+]/', $this->phone)) {
            $this->errors[] = 'Phone number cannot contain alphabetic characters or special characters other than "+", "-", "(", ")" and spaces';
        }

        // Check if the total length of the digits (ignoring symbols) is between 7 and 15
        $digitCount = preg_match_all('/\d/', $this->phone);
        if ($digitCount < 7 || $digitCount > 15) {
            $this->errors[] = 'Phone number must have between 7 and 15 digits';
        }



        // Validate address
        if (strlen($this->address) < 5) {
            $this->errors[] = 'Address must be at least 5 characters long';
        }

        // Validate level
        if (!in_array($this->level, ['+2_pass', 'see_pass', 'bachelor_graduate', 'master_graduate', 'other'], true)) {
            $this->errors[] = 'Invalid student level';
        }

        return $this->errors;
    }
}