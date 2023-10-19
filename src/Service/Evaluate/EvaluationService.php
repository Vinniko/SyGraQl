<?php


namespace App\Service\Evaluate;


use App\Exception\Evaluate\DivideByZeroException;

class EvaluationService
{
    public function complexityIndex(array $values): float
    {
        $average = $this->average($values);
        $min = $this->min($values);
        $standardDeviation = $this->standardDeviation($values);

        if ($standardDeviation === 0) {
            throw new DivideByZeroException;
        }

        return ($average - $min) / $standardDeviation;
    }

    public function min(array $values): float
    {
        return min($values);
    }

    public function average(array $values): float
    {
        $count = count($values);

        if ($count === 0) {
            return 0;
        }

        $sum = array_sum($values);

        return $sum / $count;
    }

    public function standardDeviation(array $values): float
    {
        $average = $this->average($values);
        $count = count($values);

        $sum = array_reduce($values, function ($last, $current) use ($average) {
            return $last + pow(($current - $average), 2);
        }, 0);

        return sqrt($sum / $count);
    }
}
