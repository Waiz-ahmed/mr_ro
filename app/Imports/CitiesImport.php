<?php

namespace App\Imports;

use App\Models\City;
use App\Models\State;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CitiesImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $state = State::where('code', $row['state_code'])->first();
        if (!$state) {
            throw new \Exception("State with code '{$row['state_code']}' not found");
        }

        return new City([
            'state_id' => $state->id,
            'name'     => $row['name'],
            'status'   => $row['status'] ?? 'active',
        ]);
    }

    public function rules(): array
    {
        return [
            'state_code' => 'required|string',
            'name'       => 'required|string',
        ];
    }
}