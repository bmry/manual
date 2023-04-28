<?php

namespace Manual\Service;

use Manual\Entity\Product;
use Manual\Entity\ProductCategory;
use Manual\Exception\NoProductAvailableException;
use Manual\Service\Interfaces\ProductServiceInterface;
use Manual\Service\Interfaces\RecommenderServiceInterface;

class RecommenderService implements RecommenderServiceInterface
{
    private array $recommendation;

    /**
     * @param OptionExcludedProductService $optionExcludedProductService
     * @param ProductServiceInterface $productService
     */
    public function __construct(
        private OptionExcludedProductService $optionExcludedProductService,
        private ProductServiceInterface $productService,
    ) {
    }

    /**
     * Process the submitted questionnaire and return  instances of recommended Products
     * @param string $submittedQuestionnaire
     * @param ProductCategory $productCategory
     * @return array
     */
    public function getRecommendationFromCategoryBasedOnQuestionnaire(string $submittedQuestionnaire, ProductCategory $productCategory): array
    {
        $categoryProductList = $this->productService->getProductSlugListByCategory($productCategory);
        $questionnaire = json_decode($submittedQuestionnaire, true);
        $questions = $questionnaire['questions'];
        $recommendedProductIds = $this->processQuestion($questions, $categoryProductList);
        $finalRecommendation = [];
        foreach ($recommendedProductIds as $recommendedProductId) {
            $product = $this->productService->getProductBySlug($recommendedProductId);
            $finalRecommendation[] = $product->getName();
        }

        return $finalRecommendation;
    }

    /**
     * @param array $questions
     * @param array $categoryProductList
     */
    private function processQuestion(array $questions, array $categoryProductList): array
    {
        foreach ($questions as $question) {
            $questionOptions = $question['options'];
            foreach ($questionOptions as $option) {
                $optionIsSelected = true === $option['selected'];
                if ($optionIsSelected) {
                    $excludedProducts = $this->optionExcludedProductService->getOptionExcludedProductSlug($option['id']);
                    $optionHasExcludedProducts = count($excludedProducts) > 0;

                    if ($optionHasExcludedProducts) {
                        $this->recommendation = $this->removeProductFromAvailableProduct($excludedProducts, $categoryProductList);
                    }
                }

                $optionHasQuestions = count($option['questions']) > 0;
                if ($optionHasQuestions && $optionIsSelected) {
                    $this->processQuestion($option['questions'], $categoryProductList);
                }
            }
        }

        return $this->recommendation;
    }

    /**
     * Remove exluded product from available product and return list of the potential
     * options for further processing.
     *
     * @param array $toBeExcludedProductList
     * @param array $availableProductIds
     * @return array
     * @throws NoProductAvailableException
     */
    private function removeProductFromAvailableProduct(array $toBeExcludedProductList, array $availableProductIds)
    {
        if ($toBeExcludedProductList[0] === 'exclude_all') {
            throw new NoProductAvailableException();
        }

        $excludeAllKey = array_search('exclude_all', $availableProductIds);
        unset($availableProductIds[$excludeAllKey]);

        foreach ($toBeExcludedProductList as $productId) {
            if (($key = array_search($productId, $availableProductIds)) !== false) {
                unset($availableProductIds[$key]);
            }
        }
        return $availableProductIds;
    }
}
