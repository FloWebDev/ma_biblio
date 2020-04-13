<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class SlugConstraint extends Constraint
{
    public $message = 'Identifiant déjà utilisé';
}