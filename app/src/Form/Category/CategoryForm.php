<?php

namespace Aimocs\Iis\Form\Category;

use Aimocs\Iis\Entity\Category;
use Aimocs\Iis\Repo\CategoryMapper;

class CategoryForm
{
    private string $categoryName;
    private string $description;

    private array $errors = [];

    public function __construct(private CategoryMapper $categoryMapper)
    {
    }

    public function setFields(string $categoryName, string $description): void
    {
        $this->categoryName = $categoryName;
        $this->description = $description;
    }

    public function save(): Category
    {
        $category = Category::create($this->categoryName, $this->description);
        $this->categoryMapper->save($category);
        return $category;
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

        // Validate category name (non-empty, between 3 and 50 characters)
        if (strlen($this->categoryName) < 3 || strlen($this->categoryName) > 50) {
            $this->errors[] = 'Category name must be between 3 and 50 characters';
        }

        // Validate description (optional, but if provided, should be less than 255 characters)
        if (!empty($this->description) && strlen($this->description) > 255) {
            $this->errors[] = 'Description must be less than 255 characters';
        }

        return $this->errors;
    }
}
