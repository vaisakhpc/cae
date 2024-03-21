<?php

namespace App\Services;

interface PersisterServiceInterface
{
    public function saveEntries(array $entries): array;
}