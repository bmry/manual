<?php

namespace Manual\Service\Interfaces;

use Manual\Entity\Option;

interface OptionServiceInterface
{
    public function getOptionBySlug(string $slug): Option;
}
