<?php

namespace App\Lib\Controller;

use App\Lib\Exception\BadRequestException;

class AListView extends AResponse
{
    protected function get200Response(): array
    {
        return [
            "sort_data" => $this->buildSort(),
            "pager" => $this->buildPager(),
            "form_data" => $this->buildFormData(),
            "items" => array_slice($this->mockClass::ITEMS, 0, 10),
            "meta_data" => $this->buildMetadata(),
            "rate_limit" => $this->buildRateLimit(),
        ];
    }

    protected function get400Response(): array
    {
        $errors = $this->mockClass::ERRORS;
        $rand = rand(0, count($errors) - 1);
        throw new BadRequestException($errors[$rand] ?? []);
    }

    private function buildSort(): array
    {
        return [
            "sort_column" => "id",
            "sort_order" => rand(1, 2) <= 1 ? "asc" : "desc",
            "sort_columns" => [
                "id"
            ],
        ];
    }

    private function buildPager(): array
    {
        return [
            "page" => 1,
            "item_per_page" => 10,
            "total_pages" => ceil(count($this->mockClass::ITEMS) / 10),
            "total_rows" => count($this->mockClass::ITEMS),
        ];
    }

    private function buildFormData(): array
    {
        return $this->apiRequest->getAllQueryParams()['search'] ?? [];
    }

    private function buildMetadata(): array
    {
        return [];
    }

    private function buildRateLimit(): array
    {
        return [
            'max' => 300,
            'current' => 1,
            'reset_time' => "2024-07-01 16:48:54",
        ];
    }

}