<?php

namespace App\Controller\API;

use Manual\Exception\ManualException;
use Manual\Service\Interfaces\ProductCategoryServiceInterface;
use Manual\Service\Interfaces\RecommenderServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    '/api/categories/{categoryId}/questionnaire.json',
    methods: ['POST'],
    format: 'json',
    name: 'post_category_questionnaire'
)]
class PostQuestionnaireControllerAction extends AbstractController
{
    public function __construct(
        private RecommenderServiceInterface $recommenderService,
        private ProductCategoryServiceInterface $productCategoryService
    ) {
    }

    public function __invoke(Request $request, int $categoryId)
    {
        $submittedQuestionnaire = $request->getContent();
        $productCategory = $this->productCategoryService->getProductCategoryById($categoryId);

        $response = [
        ];
        try {
            $recommendation = $this->recommenderService
                ->getRecommendationFromCategoryBasedOnQuestionnaire($submittedQuestionnaire, $productCategory);

            $response['data'] = [
                'recommendation' => $recommendation,
            ];
        } catch (ManualException $manualException) {
            $response['data'] = $manualException->getMessage();
        }

        return new JsonResponse($response);
    }
}
