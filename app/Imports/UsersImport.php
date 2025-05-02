<?php

declare(strict_types=1);

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class UsersImport implements
    ToCollection,
    WithHeadingRow,
    WithChunkReading,
    WithValidation,
    SkipsEmptyRows
{
    use Importable;

    /**
    * Get the users and save
    * @param Collection $rows
    * @method collection
    * @return void
    */
    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            $user = new User();
            $user->name = $row['name'];
            $user->email = $row['email'];
            $user->password = bcrypt('admin123');
            $user->save();
        }
    }
    /**
        * List of validation rules defined
        * @method rules
        * @return array
    */
    public function rules(): array
    {
        return[
           'email' => 'required|unique:users,email|string',
           'name'  => 'required',
        ];
    }
    /**
        * Size of chunk defined here.
        * @method chunkSize
        * @return int
    */
    public function chunkSize(): int
    {
        return 100;
    }
}
