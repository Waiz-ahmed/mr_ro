<?php

namespace App\Imports;

use App\Models\State;
use App\Models\Country;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StatesImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $country = Country::where('code', $row['country_code'])->first();
        if (!$country) {
            throw new \Exception("Country with code '{$row['country_code']}' not found");
        }

        return new State([
            'country_id' => $country->id,
            'name'       => $row['name'],
            'code'       => $row['code'] ?? null,
            'status'     => $row['status'] ?? 'active',
        ]);
    }

    public function rules(): array
    {
        return [
            'country_code' => 'required|string',
            'name'         => 'required|string',
        ];
    }
}