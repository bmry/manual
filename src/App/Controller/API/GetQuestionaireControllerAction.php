<?php

namespace App\Controller\API;

use App\Util\SerializerUtil;
use Manual\Service\Interfaces\ProductCategoryServiceInterface;
use Manual\Service\Interfaces\QuestionnaireServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    '/api/categories/{categoryId}/questionnaire.json',
    methods: ['GET'],
    format: 'json',
    name: 'get_category_questionnaire'
)]
class GetQuestionaireControllerAction extends AbstractController
{
    public function __construct(
        private QuestionnaireServiceInterface $questionnaireService,
        private ProductCategoryServiceInterface $productCategoryService
    ) {
    }

    public function __invoke(int $categoryId)
    {
        $productCategory = $this->productCategoryService->getProductCategoryById($categoryId);
        $questionnaire = $this->questionnaireService->getNormalizedQuestionaireByProductCategory($productCategory);
        $serializer = SerializerUtil::buildSerializer();
        return new JsonResponse($serializer->normalize($questionnaire));
    }
}
