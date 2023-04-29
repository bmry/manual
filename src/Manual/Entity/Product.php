<?php

namespace Manual\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $slug;

    #[ORM\ManyToOne(targetEntity: ProductCategory::class, inversedBy: 'products')]
    private $category;

    #[ORM\Column(type: 'datetime')]
    private $created;

    #[ORM\Column(type: 'datetime')]
    private $updated;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'childProducts')]
    #[ORM\JoinColumn(name: 'parent_id', referencedColumnName: 'id')]
    private $parent;

    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'parent')]
    private $childProducts;

    public function __construct()
    {
        $this->created = new \DateTime('now');
        $this->updated = new \DateTime('now');
        $this->childProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getCategory(): ?ProductCategory
    {
        return $this->category;
    }

    public function setCategory(?ProductCategory $category): self
    {
        $this->category = $category;

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

    public function __toString(): string
    {
        return $this->getName();
    }

    public function setParent(Product $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function getParent(): ?Product
    {
        return $this->parent;
    }

    public function getChildProducts(): ArrayCollection
    {
        return $this->childProducts;
    }

    public function addChildProduct(Product $childProduct): self
    {
        if (! $this->childProducts->contains($childProduct)) {
            $this->childProducts[] = $childProduct;
            $childProduct->setParent($this);
        }

        return $this;
    }

    public function removeChildProduct(Product $product): self
    {
        if ($this->childProducts->removeElement($product)) {
            if ($product->getParent() === $this) {
                $product->setParent(null);
            }
        }

        return $this;
    }

    public function isParent(): bool
    {
        return $this->getChildProducts()->count() > 0;
    }
}
