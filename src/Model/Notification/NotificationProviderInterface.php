<?php

declare(strict_types=1);

namespace Randock\AdminPressBundle\Model\Notification;

interface NotificationProviderInterface
{
    /**
     * @return Notification[]
     */
    public function getNotifications(): array;

    /**
     * @return string
     */
    public function getIcon(): string;

    /**
     * @return bool
     */
    public function isHeartbit(): bool;

    /**
     * @return string|null
     */
    public function getPanelTitle(): ?string;

    /**
     * @return string|null
     */
    public function getSeeAllTitle(): ?string;

    /**
     * @return string|null
     */
    public function getSeeAllLink(): ?string;
}
