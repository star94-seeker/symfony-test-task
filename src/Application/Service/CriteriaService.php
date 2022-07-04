<?php

namespace App\Api\Application\Service;

use Exception;

class CriteriaService
{
    private array $criterias;

    public function __construct(array $criterias)
    {
        $this->criterias = $criterias;
    }

    public function getConfigs(): array
    {
        return $this->criterias;
    }

    public function isCriteriaEnabled(string $criteria)
    {
        if(!in_array($criteria, $this->criterias)) {
            throw new Exception("Criteria not found");
        }

        if (true === $this->criterias[$criteria]) {
            return true;
        }
        else{
            return false;
        }
    }
}
