<?php

namespace Manual\Service;

use App\Repository\OptionExcludedProductRepository;
use Manual\Service\Interfaces\OptionServiceInterface;

class OptionExcludedProductService
{
    public function __construct(
        private OptionExcludedProductRepository $optionExcludedProductRepository,
        private OptionServiceInterface $optionService
    ) {
    }

    /**
     * Gets the slug list of product excluded by a given option.
     *
     * @param string $optionSlug
     */
    public function getOptionExcludedProductSlug(string $optionSlug): array
    {
        $option = $this->optionService->getOptionBySlug($optionSlug);
        return $this->optionExcludedProductRepository->getOptionExcludedProductSlug($option);
    }
}
