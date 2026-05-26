<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CustomerAccount;

class CustomerAccountSeeder extends Seeder
{
    public function run(): void
    {
        $customers=[

            [

                'name'=>'Leann',

                'email'=>'leann@gmail.com',

                'phone'=>'081234567890',

                'address'=>'Jepara',

                'status'=>'Active'

            ],

            [

                'name'=>'Billean',

                'email'=>'billean@gmail.com',

                'phone'=>'082345678901',

                'address'=>'Semarang',

                'status'=>'Active'

            ],

            [

                'name'=>'Rizky',

                'email'=>'rizky@gmail.com',

                'phone'=>'083456789012',

                'address'=>'Jakarta',

                'status'=>'Blocked'

            ],

            [

                'name'=>'Andi',

                'email'=>'andi@gmail.com',

                'phone'=>'084567890123',

                'address'=>'Bandung',

                'status'=>'Active'

            ],

            [

                'name'=>'Dimas',

                'email'=>'dimas@gmail.com',

                'phone'=>'085678901234',

                'address'=>'Surabaya',

                'status'=>'Active'

            ]

        ];

        foreach($customers as $customer){

            CustomerAccount::create($customer);

        }
    }
}