<?php

namespace App\Exports;
use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;


class CustomersExport implements FromQuery, WithHeadings
{
    use Exportable;

    public function headings(): array
    {
        return [
            'Name',
            'Phone',
            'Gender',
            'Amount Deposited',
            'Device Time',
            'Comment',
            'Location',
            'Account Type',
            'Added By',
        ];
    }

    public function query()
    {
        return Customer::query()
                ->join('users','users.id','customers.user_id')
                    ->join('accounts','accounts.id','customers.account_id')
                    ->select('customers.name','customers.phone','customers.gender','customers.amount_deposited'
                           , 'customers.device_time','customers.comment','customers.location','accounts.name as account','users.name as user');
                    // ->get();
    }
}
