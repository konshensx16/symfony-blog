<?php

namespace App\Services;

use App\Entity\Article;
use App\Entity\NotificationType;
use App\Repository\NotificationRepository;
use App\Services\Notification\Factory\NotificationFactory;
use Symfony\Component\Mercure\Publisher;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class that allows to publish an Update object.
 */
class Notifier
{
    /**
     * @var NotificationFactory
     */
    private $notificationFactory;

    /**
     * @var NotificationRepository
     */
    private $notificationRepository;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(
        NotificationFactory $notificationFactory,
        NotificationRepository $notificationRepository,
        SerializerInterface $serializer
    ) {
        $this->notificationFactory = $notificationFactory;
        $this->notificationRepository = $notificationRepository;
        $this->serializer = $serializer;
    }

    public function articleCreated(Article $article, Publisher $publisher)
    {
        $notification = $this->notificationFactory->create($article, NotificationType::ARTICLE_CREATED);
        $this->notificationRepository->save($notification);

        $jsonContent = $this->serializer->serialize($notification, 'json');

        $update = new Update(
            'http://symfony-blog.fr/new/article',
            $jsonContent,
            ['http://symfony-blog.fr/group/users']
        );

        $publisher($update);
    }
}
