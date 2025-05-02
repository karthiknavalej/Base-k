<?php

declare(strict_types=1);

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Database\Eloquent\Builder;

class UsersExport implements
    FromQuery,
    ShouldAutoSize,
    WithMapping,
    WithHeadings
{
    use Exportable;

    /**
     * @type User
     */
    protected $users;
    /**
     * @method __construct
     */
    public function __construct()
    {
        $this->users = new User();
    }

    /**
      * Prepares the query for an export.
      * @method query
      * @return Illuminate\Database\Eloquent\Builder
    */
    public function query(): ?Builder
    {
        return $this->users->query();
    }
    /**
      * Columns to be exported are defined here.
      * @method map
      * @param $user
      * @return array
    */
    public function map($user): array
    {
        return[
            $user ->id,
            $user ->name,
            $user ->email,
            $user ->created_at,

        ];
    }
    /**
      * Defining headings of export data.
      * @method headings
      * @return array
    */
    public function headings(): array
    {
        return [
            'Id',
            'Name',
            'Email',
            'Created_At',
        ];
    }
}
