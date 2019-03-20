<?php

declare(strict_types=1);

namespace Randock\AdminPressBundle\Model\Notification;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Randock\AdminPressBundle\Model\ValidationException;

class NotificationValidator
{
    public static function getConstraints(): array
    {
        return [
            'title' => [
                new Length(['max' => 20]),
                new NotBlank(),
            ],
            'subTitle' => [
                new Length(['max' => 30]),
            ],
            'type' => [
                new Choice(['choices' => Notification::getTypes()]),
            ],
        ];
    }

    /**
     * @param array $data
     *
     * @throws ValidationException
     */
    public static function validate(array $data)
    {
        $validator = Validation::createValidator();

        foreach (self::getConstraints() as $prop => $constraints) {
            if (\array_key_exists($prop, $data)) {
                $violations = $validator->validate($data[$prop], $constraints);

                if (\count($violations)) {
                    throw new ValidationException($violations->get(0)->getMessage());
                }
            }
        }
    }
}
