<?php

namespace Manual\Service;

use App\Repository\QuestionaireRepository;
use Manual\Builder\QuestionBuilder;
use Manual\Dto\QuestionaireDto;
use Manual\Entity\ProductCategory;
use Manual\Entity\Questionnaire;
use Manual\Exception\NotFoundException;
use Manual\Service\Interfaces\ProductServiceInterface;
use Manual\Service\Interfaces\QuestionnaireServiceInterface;
use Manual\Service\Interfaces\QuestionServiceInterface;

class QuestionnaireService implements QuestionnaireServiceInterface
{
    private $recommendation;

    /**
     * @param QuestionaireRepository $questionnaireRepository
     */
    public function __construct(
        private QuestionaireRepository $questionnaireRepository,
        private QuestionServiceInterface $questionService,
        private ProductServiceInterface $productService,
        private OptionExcludedProductService $optionExcludedProductService
    ) {
    }

     /**
      * @param ProductCategory $productCategory
      * @return Questionnaire
      */
     public function getQuestionnaireByProductCategory(ProductCategory $productCategory): Questionnaire
     {
         $questionnaire = $this->questionnaireRepository->findOneBy([
             'productCategory' => $productCategory,
         ]);

         if (! $questionnaire instanceof Questionnaire) {
             throw new NotFoundException("There is not questionnaire for productCategory: $productCategory");
         }

         return $questionnaire;
     }

     /**
      * @param ProductCategory $productCategory
      * @return QuestionaireDto
      */
     public function getNormalizedQuestionaireByProductCategory(ProductCategory $productCategory): QuestionaireDto
     {
         $questionnaire = $this->getQuestionnaireByProductCategory($productCategory);
         $questions = $this->questionService->getQuestionsByQuestionnaire($questionnaire);
         $questionnaireDTO = new QuestionaireDto($questionnaire->getTitle(), $questionnaire->getDescription());

         foreach ($questions as $question) {
             $questionnaireDTO->addQuestion(QuestionBuilder::buildQuestion($question));
         }

         return $questionnaireDTO;
     }
}
