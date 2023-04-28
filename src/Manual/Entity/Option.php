<?php

namespace Manual\Entity;

use App\Repository\OptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: OptionRepository::class)]
#[ORM\Table(name: '`option`')]
class Option
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $text;

    #[ORM\Column(type: 'string', length: 255)]
    private $slug;

    #[ORM\Column(type: 'datetime')]
    private $created;

    #[ORM\Column(type: 'datetime')]
    private $updated;

    #[ORM\ManyToOne(targetEntity: Question::class, inversedBy: 'options')]
    #[ORM\JoinColumn(nullable: false)]
    private $question;

    #[ORM\OneToMany(mappedBy: 'optionId', targetEntity: OptionQuestion::class, cascade: ['persist'])]
    private $optionQuestions;

    #[ORM\OneToMany(mappedBy: 'option', targetEntity: OptionExcludedProduct::class, cascade: ['persist'])]
    private $optionExcludedProducts;

    #[ORM\Column(type: 'integer')]
    private $position;

    public function __construct()
    {
        $this->optionQuestions = new ArrayCollection();
        $this->optionExcludedProducts = new ArrayCollection();
        $this->created = new \DateTime('now');
        $this->updated = new \DateTime('now');
        $this->slug = 'option_' . Uuid::v1();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }

    /**
     * @return Collection<int, OptionQuestion>
     */
    public function getOptionQuestions(): Collection
    {
        return $this->optionQuestions;
    }

    public function addOptionQuestion(OptionQuestion $optionQuestion): self
    {
        if (! $this->optionQuestions->contains($optionQuestion)) {
            $this->optionQuestions[] = $optionQuestion;
            $optionQuestion->setOptionId($this);
        }

        return $this;
    }

    public function removeOptionQuestion(OptionQuestion $optionQuestion): self
    {
        if ($this->optionQuestions->removeElement($optionQuestion)) {
            // set the owning side to null (unless already changed)
            if ($optionQuestion->getOptionId() === $this) {
                $optionQuestion->setOptionId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, OptionQuestion>
     */
    public function getOptionExcludedProducts(): Collection
    {
        return $this->optionExcludedProducts;
    }

    public function addOptionExcludedProduct(OptionExcludedProduct $optionExcludedProduct): self
    {
        if (! $this->optionExcludedProducts->contains($optionExcludedProduct)) {
            $this->optionExcludedProducts[] = $optionExcludedProduct;
            $optionExcludedProduct->setOption($this);
        }

        return $this;
    }

    public function removeOptionExcludedProduct(OptionExcludedProduct $optionExcludedProduct): self
    {
        if ($this->optionExcludedProducts->removeElement($optionExcludedProduct)) {
            // set the owning side to null (unless already changed)
            if ($optionExcludedProduct->getOption() === $this) {
                $optionExcludedProduct->setOption(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPosition(): ?int
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition(?int $position): self
    {
        $this->position = $position;
        return $this;
    }

    public function __toString(): string
    {
        return $this->getText();
    }
}
