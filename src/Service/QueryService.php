<?php

namespace App\Service;

use App\DTO\StatDTO;
use App\Repository\TagRepository;
use App\Service\Evaluate\EvaluationService;

class QueryService
{
    private TagRepository $tagRepository;
    private EvaluationService $evaluationService;

    public function __construct(TagRepository $tagRepository, EvaluationService $evaluationService) {
        $this->tagRepository = $tagRepository;
        $this->evaluationService = $evaluationService;
    }

    public function getStat(?\DateTime $startDate, ?\DateTime $endDate, ?string $type)
    {
        $scores = $this->tagRepository->getStatsByTypeAndBetweenDates($startDate, $endDate, $type);

        $scores = array_map(function ($score) {
            return $score['score'];
        }, $scores);

        $stat = new StatDTO();

        if (empty($scores)) {
            $stat->averageValue = 0;
            $stat->complexityIndex = 0;
            $stat->standardDeviation = 0;

            return $stat;
        }

        $stat->averageValue = $this->evaluationService->average($scores);
        $stat->complexityIndex = $this->evaluationService->complexityIndex($scores);
        $stat->standardDeviation = $this->evaluationService->standardDeviation($scores);

        return $stat;
    }
}
