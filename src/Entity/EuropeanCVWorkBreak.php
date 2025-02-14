<?php

namespace Trexima\EuropeanCvBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Proxy;
use Symfony\Component\Validator\Constraints as Assert;
use Trexima\EuropeanCvBundle\Entity\Embeddable\MonthYearRange;
use Trexima\EuropeanCvBundle\Entity\Enum\WorkBreakEnum;

/**
 * EuropeanCV work break
 */
#[ORM\Table(name: 'european_cv_work_break')]
#[ORM\Entity]
class EuropeanCVWorkBreak
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: EuropeanCV::class, inversedBy: 'workBreaks')]
    #[ORM\JoinColumn(name: 'european_cv_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?EuropeanCV $europeanCV = null;

    #[ORM\Embedded(class: MonthYearRange::class)]
    private MonthYearRange $dateRange;

    #[Assert\Length(max: 100, maxMessage: 'trexima_european_cv.max_length_reached')]
    #[ORM\Column(type: 'string', length: 256, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(type: 'smallint', nullable: true, enumType: WorkBreakEnum::class)]
    private ?WorkBreakEnum $type = null;

    #[Assert\Length(max: 4000, maxMessage: 'trexima_european_cv.max_length_reached')]
    #[ORM\Column(type: 'text', length: 65535, nullable: true)]
    private ?string $description = null;

    public function __construct()
    {
        $this->dateRange = new MonthYearRange();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEuropeanCV(): ?EuropeanCV
    {
        return $this->europeanCV;
    }

    public function setEuropeanCV(?EuropeanCV $europeanCV): self
    {
        $this->europeanCV = $europeanCV;

        return $this;
    }

    public function getDateRange(): MonthYearRange
    {
        return $this->dateRange;
    }

    public function setDateRange(MonthYearRange $dateRange): self
    {
        $this->dateRange = $dateRange;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getType(): ?WorkBreakEnum
    {
        return $this->type;
    }

    public function setType(?WorkBreakEnum $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function __clone()
    {
        /*
         * If the entity has an identity, proceed as normal.
         * https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/cookbook/implementing-wakeup-or-clone.html
         */
        if ($this->id) {
            if ($this instanceof Proxy && !$this->__isInitialized()) {
                $this->__load();
            }

            $this->id = null;

            $dateRange = clone $this->getDateRange();
            $this->setDateRange($dateRange);
        }
    }
}
