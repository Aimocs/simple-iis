<?php

namespace Aimocs\Iis\Form\Employee;

use Aimocs\Iis\Entity\Employee;
use Aimocs\Iis\Repo\EmployeeMapper;
use Aimocs\Iis\Repo\EmployeeTypeRepo;

class EmployeeForm
{
    private string $firstName;
    private ?string $middleName;
    private string $lastName;
    private string $phone;
    private string $email;
    private string $employeeType;
    private string $dateOfJoin;

    private array $errors = [];

    public function __construct(private EmployeeMapper $employeeMapper, private EmployeeTypeRepo $employeeTypeRepo)
    {
    }

    public function setFields(
        string  $firstName,
        ?string $middleName,
        string  $lastName,
        string  $phone,
        string  $email,
        int  $employeeType,
        string  $dateOfJoin
    ): void
    {
        $this->firstName = $firstName;
        $this->middleName = $middleName;
        $this->lastName = $lastName;
        $this->phone = $phone;
        $this->email = $email;
        $this->employeeType = $employeeType;
        $this->dateOfJoin = $dateOfJoin;
    }

    public function save(): Employee
    {
        $empType = $this->employeeTypeRepo->findById($this->employeeType);

        $employee = Employee::create(
            $this->firstName,
            $this->middleName,
            $this->lastName,
            $this->phone,
            $this->email,
            new \DateTimeImmutable($this->dateOfJoin),
            $empType
        );
        $this->employeeMapper->save($employee);
        return $employee;
    }

    /**
     * Check if the form has validation errors.
     *
     * @return bool
     */
    public function hasValidationErrors(): bool
    {
        return count($this->getValidationErrors()) > 0;
    }

    /**
     * Get all validation errors for the form.
     *
     * @return array
     */
    public function getValidationErrors(): array
    {
        if (!empty($this->errors)) {
            return $this->errors;
        }

        // Validate names
        if (strlen($this->firstName) < 2 || strlen($this->lastName) < 2) {
            $this->errors[] = 'First and last names must be at least 2 characters long';
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

        // Validate email
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = 'Email must be a valid email address';
        }

        // Validate employee type
        if (!in_array($this->employeeType, ['1', '2' ,'3'])) {
            $this->errors[] = 'Invalid employee type selected';
        }

        // Validate date of joining
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->dateOfJoin)) {
            $this->errors[] = 'Date of joining must be in YYYY-MM-DD format';
        }

        return $this->errors;
    }
}
