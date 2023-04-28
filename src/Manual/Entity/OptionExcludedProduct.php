<?php

namespace Manual\Entity;

use App\Repository\OptionExcludedProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OptionExcludedProductRepository::class)]
class OptionExcludedProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    #[ORM\ManyToOne(targetEntity: Option::class, inversedBy: 'optionQuestions')]
    private $option;

    #[ORM\ManyToOne(targetEntity: Product::class)]
    private $product;

    public function getOption(): Option
    {
        return $this->option;
    }

    public function setOption($option): self
    {
        $this->option = $option;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}
