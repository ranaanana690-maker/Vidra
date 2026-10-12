<?php

namespace App\Packages\DataTransfer\Helpers\Importers\Staff;

use App\Packages\DataTransfer\Helpers\Importers\AbstractImporter;
use App\Packages\StaffManagement\Models\Staff;
use Illuminate\Support\Facades\Validator;

class Importer extends AbstractImporter
{
    protected array $permanentAttributes = ['first_name', 'last_name', 'email'];

    public function getValidColumnNames(): array
    {
        return [
            'first_name', 'last_name', 'date_of_birth', 'gender',
            'phone_number', 'email', 'address', 'nationality',
            'joining_date', 'designation', 'employment_type', 'status',
        ];
    }

    /**
     * Normalize enum casing from CSV to match DB enums:
     * gender [Male,Female,Other], employment_type [Permanent,Temporary,Contract],
     * status [Active,Inactive,Resigned].
     * Legacy aliases: full-time->Permanent, part-time->Temporary,
     * on_leave->Inactive, terminated->Resigned.
     */
    private function normalizeRow(array $row): array
    {
        if (! empty($row['gender'])) {
            $row['gender'] = ucfirst(strtolower(trim((string) $row['gender'])));
        }
        if (! empty($row['employment_type'])) {
            $type = strtolower(trim((string) $row['employment_type']));
            $row['employment_type'] = match ($type) {
                'full-time', 'permanent' => 'Permanent',
                'part-time', 'temporary' => 'Temporary',
                'contract' => 'Contract',
                default => $row['employment_type'],
            };
        }
        if (! empty($row['status'])) {
            $status = strtolower(trim((string) $row['status']));
            $row['status'] = match ($status) {
                'active' => 'Active',
                'inactive', 'on_leave' => 'Inactive',
                'resigned', 'terminated' => 'Resigned',
                default => $row['status'],
            };
        }

        return $row;
    }

    public function validateRow(array $row, int $rowNumber): bool
    {
        $row = $this->normalizeRow($row);

        $validator = Validator::make($row, [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email',
            'gender' => 'nullable|in:Male,Female,Other',
            'date_of_birth' => 'nullable|date',
            'joining_date' => 'nullable|date',
            'employment_type' => 'nullable|in:Permanent,Temporary,Contract',
            'status' => 'nullable|in:Active,Inactive,Resigned',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $msg) {
                $this->addError($rowNumber, $msg);
            }

            return false;
        }

        return true;
    }

    public function processRow(array $row, string $action): void
    {
        $row = $this->normalizeRow($row);

        $existing = Staff::where('email', $row['email'])->first();

        $data = array_filter([
            'first_name' => $row['first_name'] ?? null,
            'last_name' => $row['last_name'] ?? null,
            'date_of_birth' => $row['date_of_birth'] ?? null,
            'gender' => $row['gender'] ?? null,
            'phone_number' => $row['phone_number'] ?? null,
            'email' => $row['email'],
            'address' => $row['address'] ?? null,
            'nationality' => $row['nationality'] ?? null,
            'joining_date' => $row['joining_date'] ?? null,
            'designation' => $row['designation'] ?? null,
            'employment_type' => $row['employment_type'] ?? 'Permanent',
            'status' => $row['status'] ?? 'Active',
        ], fn ($v) => $v !== null && $v !== '');

        if ($action === 'delete') {
            if ($existing) {
                $existing->delete();
                $this->deletedItemsCount++;
            }

            return;
        }

        if ($existing) {
            $existing->update($data);
            $this->updatedItemsCount++;
        } else {
            Staff::create($data);
            $this->createdItemsCount++;
        }
    }

    public static function sampleHeaders(): array
    {
        return [
            'first_name', 'last_name', 'date_of_birth', 'gender',
            'phone_number', 'email', 'address', 'nationality',
            'joining_date', 'designation', 'employment_type', 'status',
        ];
    }
}
