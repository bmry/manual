<?php

namespace Manual\Entity;

use App\Repository\OptionQuestionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OptionQuestionRepository::class)]
class OptionQuestion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Option::class, inversedBy: 'optionQuestions')]
    private $optionId;

    #[ORM\OneToOne(targetEntity: Question::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $question;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOptionId(): ?Option
    {
        return $this->optionId;
    }

    public function setOptionId(?Option $optionId): self
    {
        $this->optionId = $optionId;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(Question $question): self
    {
        $this->question = $question;

        return $this;
    }
}
