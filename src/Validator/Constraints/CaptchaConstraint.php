<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CaptchaConstraint extends Constraint
{
    public $message = 'Le captcha "{{ integer }}" est incorrect.';
}