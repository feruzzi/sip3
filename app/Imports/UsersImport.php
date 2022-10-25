<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Hash;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new User([
            'username'     => $row['username'],
            'name'    => $row['name'],
            'password' => Hash::make($row['password']),
            'group1'    => $row['group1'],
            'group2'    => $row['group2'],
            'level'    => $row['level'],
            'status'    => $row['status'],
        ]);
    }
}