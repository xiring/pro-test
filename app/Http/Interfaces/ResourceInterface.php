<?php

namespace App\Http\Interfaces;

interface ResourceInterface {

    public function toArray($request);

    public function getFillableRecord($item): array;

    public function getModelData(): array;

    public function getIncludeFields(): array;

    public function getExceptFields(): array;

    public function with($request): array;

}
