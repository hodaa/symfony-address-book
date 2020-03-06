<?php


namespace AppBundle\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Date;


class ValidationService
{
    public function __construct(
        CsrfTokenManagerInterface $tokenManager,
        ValidatorInterface $validator,
        PropertyAccessorInterface $accessor,
        LoggerInterface $logger
    ) {
        $this->tokenManager = $tokenManager;
        $this->validator = $validator;
        $this->accessor = $accessor;
        $this->logger = $logger;
    }

    /**
     * @param $token
     * @return bool
     */
    public function validateToken($token): bool
    {
        $csrf_token = new CsrfToken('address_book_form', $token);

        $isValid = $this->tokenManager->isTokenValid($csrf_token);

        if (!$isValid) {
            $this->logger->error("CSRF failure");
        }

        return $isValid;
    }

    /**
     * @param array $input
     * @return array
     */
    public function validateInput(array $input): array
    {
        $constraints = new Assert\Collection([
            'first_name' => [new Assert\Length(['min' => 3]),new NotBlank(["message" => "First name shouldn't be empty"])],
            'last_name' => new NotBlank(["message" => "Last name shouldn't be empty"]),
            'street' => new Assert\Optional(),
            'city' => new Assert\Optional(),
            'country' => new Assert\Optional(),
            'phone_number' => new Assert\Optional(),
            'birthday' => [new NotBlank(["message" => "Birthday shouldn't be empty"]),new Date(['message' => "Birthday is not a valid date"])],
            'email' => [new Assert\Optional(), new Email()],
            'zip' => new Assert\Length(['min' => 5,'minMessage' => "Zip value is too short"]),
            'picture' => new Assert\Image(
                [
                    "mimeTypesMessage" => "Please upload a valid Image"
                ]
            )
        ]);

        $violations = $this->validator->validate($input, $constraints);

        if (count($violations) > 0) {
            $this->logger->info("Validation failed");

            $messages = [];

            foreach ($violations as $violation) {
                $this->accessor->setValue(
                    $messages,
                    $violation->getPropertyPath(),
                    $violation->getMessage()
                );
            }
            return $messages;
        } else {
            return [];
        }
    }
}
