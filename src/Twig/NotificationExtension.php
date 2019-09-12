<?php

namespace App\Twig;

use App\Repository\NotificationRepository;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

/**
 * This extension creates a global variable of number of notification for the current user
 */
class NotificationExtension extends AbstractExtension implements GlobalsInterface
{
    /**
     * @var NotificationRepository
     */
    private $notificationRepository;

    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * Returns a list of global variables to add to the existing list.
     *
     * @return array
     */
    public function getGlobals()
    {
        $notifications = $this->notificationRepository->findAll();

        return ['notifications' => $notifications];
    }
}
