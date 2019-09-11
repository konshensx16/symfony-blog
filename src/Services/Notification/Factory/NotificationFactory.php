<?php

namespace App\Services\Notification\Factory;

use App\Entity\Notification;
use App\Repository\NotificationTypeRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class NotificationFactory
{
    /**
     * @var NotificationTypeRepository
     */

    private $notificationTypeRepository;
    /**
     * @var TokenStorageInterface
     */
    private $storage;

    public function __construct(NotificationTypeRepository $notificationTypeRepository, TokenStorageInterface $storage)
    {
        $this->notificationTypeRepository = $notificationTypeRepository;
        $this->storage = $storage;
    }

    public function create(string $notificationTypeName): Notification
    {
        $notificationType = $this->notificationTypeRepository->findOneBy(['name' => $notificationTypeName]);
        $notification = (new Notification())
                ->setNotificationType($notificationType)
                ->setCreatedBy($this->storage->getToken()->getUser());

        return $notification;
    }
}
