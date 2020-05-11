<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UserEmailConstraint extends Constraint
{
    public $message = 'Aucun utilisateur trouvé avec cet email.';
}