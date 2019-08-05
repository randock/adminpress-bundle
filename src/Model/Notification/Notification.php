<?php

declare(strict_types=1);

namespace Randock\AdminPressBundle\Model\Notification;

use Randock\AdminPressBundle\Model\ValidationException;

class Notification
{
    public const TYPE_STATUS_ONLINE = 'online';
    public const TYPE_STATUS_BUSY = 'busy';
    public const TYPE_STATUS_AWAY = 'away';
    public const TYPE_STATUS_OFFLINE = 'offline';

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string|null
     */
    protected $subTitle;

    /**
     * @var \DateTimeImmutable|null
     */
    protected $time;

    /**
     * @var bool
     */
    private $messageRead;

    /**
     * @var string|null
     */
    protected $icon;

    /**
     * @var string|null
     */
    protected $color;

    /**
     * @var string|null
     */
    protected $type;

    /**
     * @var string|null
     */
    protected $link;


    /**
     * @param string                  $title
     * @param string|null             $subTitle
     * @param \DateTimeImmutable|null $time
     * @param bool                    $messageRead
     * @param string|null             $icon
     * @param string|null             $color
     * @param string|null             $type
     * @param string|null             $link
     */
    private function __construct(
        string $title,
        string $subTitle = null,
        \DateTimeImmutable $time = null,
        bool $messageRead = false,
        string $icon = null,
        string $color = null,
        string $type = null,
        string $link = null
    ) {
        $this->title = $title;
        $this->subTitle = $subTitle;
        $this->time = $time;
        $this->messageRead = $messageRead;
        $this->icon = $icon;
        $this->color = $color;
        $this->type = $type;
        $this->link = $link;
    }

    /**
     * @param string                  $title
     * @param string|null             $subTitle
     * @param \DateTimeImmutable|null $time
     * @param bool|null               $messageRead
     * @param string|null             $icon
     * @param string|null             $color
     * @param string|null             $type
     * @param string|null             $link
     *
     * @throws ValidationException
     *
     * @return Notification
     */
    public static function create(
        string $title,
        ?string $subTitle = null,
        ?\DateTimeImmutable $time = null,
        ?bool $messageRead = null,
        ?string $icon = null,
        ?string $color = null,
        ?string $type = null,
        ?string $link = null
    ): self {
        NotificationValidator::validate(
            [
                'title' => $title,
                'subTitle' => $subTitle,
                'time' => $time,
                'messageRead' => $messageRead,
                'icon' => $icon,
                'color' => $color,
                'type' => $type,
                'link' => $link,
            ]
        );

        return new static($title, $subTitle, $time, $messageRead, $icon, $color, $type, $link);
    }

    /**
     * @return array
     */
    public static function getTypes(): array
    {
        return [
            self::TYPE_STATUS_ONLINE,
            self::TYPE_STATUS_BUSY,
            self::TYPE_STATUS_AWAY,
            self::TYPE_STATUS_OFFLINE,
        ];
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string|null
     */
    public function getSubTitle(): ?string
    {
        return $this->subTitle;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getTime(): ?\DateTimeImmutable
    {
        return $this->time;
    }

    /**
     * @return string|null
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * @return string|null
     */
    public function getColor(): ?string
    {
        return $this->color;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * @return bool
     */
    public function isMessageRead(): bool
    {
        return $this->messageRead;
    }

    /**
     * @param bool $messageRead
     *
     * @return Notification
     */
    private function setMessageRead(bool $messageRead): self
    {
        $this->messageRead = $messageRead;

        return $this;
    }
}
