<?php

namespace Manual\Service;

use App\Repository\OptionRepository;
use Manual\Entity\Option;
use Manual\Exception\NotFoundException;
use Manual\Service\Interfaces\OptionServiceInterface;

class OptionService implements OptionServiceInterface
{
    public function __construct(
        private OptionRepository $optionRepository
    ) {
    }

    public function getOptionBySlug(string $slug): Option
    {
        $option = $this->optionRepository->findOneBy([
            'slug' => $slug,
        ]);

        if (! $option instanceof Option) {
            throw new NotFoundException("Option does not exist");
        }

        return $option;
    }
}
