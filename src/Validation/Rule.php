<?php

namespace Jc\Validation;

use Jc\Validation\Rules\Email;
use Jc\Validation\Rules\Required;
use Jc\Validation\Rules\RequiredWith;
use Jc\Validation\Rules\ValidationRule;

class Rule {
    public static function email(): ValidationRule {
        return new Email();
    }

    public static function required(): ValidationRule {
        return new Required();
    }

    public static function requiredWith(string $withField): ValidationRule {
        return new RequiredWith($withField);
    }
}

