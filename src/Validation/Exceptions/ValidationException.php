<?php

namespace Jc\Validation\Exceptions;

use Jc\Exceptions\JcException;

class ValidationException extends JcException {
    public function __construct(protected array $errors) {
        $this->errors = $errors;
    }

    public function errors(): array {
        return $this->errors;
    }
}