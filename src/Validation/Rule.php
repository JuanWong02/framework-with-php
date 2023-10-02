<?php

namespace Jc\Validation;

use Jc\Validation\Rules\Email;
use Jc\Validation\Rules\LessThan;
use Jc\Validation\Rules\Number;
use Jc\Validation\Rules\Required;
use Jc\Validation\Rules\RequiredWhen;
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

    public static function number(): ValidationRule {
        return new Number();
    }

    public static function lessThan(int|float $value): ValidationRule {
        return new LessThan($value);
    }

    public static function requiredWhen(
        string $otherField,
        string $operator,
        int|float $value
    ): ValidationRule {
        return new RequiredWhen($otherField, $operator, $value);
    }

    public static function from(string $str): ValidationRule {
        
    }
}

