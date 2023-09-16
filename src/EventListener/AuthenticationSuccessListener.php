<?php

namespace App\EventListener;

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Serializer\SerializerInterface;

class AuthenticationSuccessListener
{

    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }
    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof User || !$user instanceof UserInterface) {
            return;
        }
        $jsonData = $this->serializer->serialize($user, 'json');

        // $data['user'] = array(
        //     'roles' => $user->getRoles(),
        //     'id' => $user->getId(),
        //     'firstName' => $user->getFirstName(),
        //     'lastName' => $user->getLastName(),
        //     'email' => $user->getEmail(),
        //     'username' => $user->getUsername(),
        //     'phone' => $user->getPhone(),
        //     // 'enabled' => $user->getEnabled(),
        //     'isActiveNow' => $user->getIsActiveNow(),
        //     'lastActivityAt' => $user->getLastActivityAt(),
        //     'sexe' => $user->getSexe(),
        //     'status' => $user->getStatus(),
        //     'adresse' => $user->getAdresse(),
        //     'avatar' => $user->getAvatar(),
        //     'demanduer' => $user->getDemandeur()
        // );
        $data['user'] = json_decode($jsonData, true);

        $event->setData($data);
    }
}
