<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $users = [

            ['Amit Patel','amit1@gmail.com','9876543210','Street 1','Near Park','Ahmedabad','Gujarat','380001'],
            ['Riya Shah','riya2@gmail.com','9876543211','Street 2',null,'Surat','Gujarat','395003'],
            ['Rahul Mehta','rahul3@gmail.com','9876543212','Street 3','Opp Mall','Vadodara','Gujarat','390001'],
            ['Neha Jain','neha4@gmail.com','9876543213','Street 4',null,'Rajkot','Gujarat','360001'],
            ['Karan Verma','karan5@gmail.com','9876543214','Street 5','Near School','Mumbai','Maharashtra','400001'],

            ['Pooja Sharma','pooja6@gmail.com','9876543215','Street 6',null,'Pune','Maharashtra','411001'],
            ['Arjun Singh','arjun7@gmail.com','9876543216','Street 7','Near Temple','Delhi','Delhi','110001'],
            ['Sneha Kapoor','sneha8@gmail.com','9876543217','Street 8',null,'Jaipur','Rajasthan','302001'],
            ['Vikram Joshi','vikram9@gmail.com','9876543218','Street 9','Near Market','Udaipur','Rajasthan','313001'],
            ['Anjali Desai','anjali10@gmail.com','9876543219','Street 10',null,'Indore','Madhya Pradesh','452001'],

            ['Rohit Kumar','rohit11@gmail.com','9876543220','Street 11','Near Hospital','Patna','Bihar','800001'],
            ['Simran Kaur','simran12@gmail.com','9876543221','Street 12',null,'Amritsar','Punjab','143001'],
            ['Manish Yadav','manish13@gmail.com','9876543222','Street 13','Near Bus Stand','Lucknow','UP','226001'],
            ['Priya Nair','priya14@gmail.com','9876543223','Street 14',null,'Kochi','Kerala','682001'],
            ['Suresh Reddy','suresh15@gmail.com','9876543224','Street 15','Near Lake','Hyderabad','Telangana','500001'],

            ['Meena Iyer','meena16@gmail.com','9876543225','Street 16',null,'Chennai','Tamil Nadu','600001'],
            ['Deepak Gupta','deepak17@gmail.com','9876543226','Street 17','Near Office','Bhopal','MP','462001'],
            ['Kavita Mishra','kavita18@gmail.com','9876543227','Street 18',null,'Varanasi','UP','221001'],
            ['Nitin Agarwal','nitin19@gmail.com','9876543228','Street 19','Near College','Nagpur','Maharashtra','440001'],
            ['Alok Das','alok20@gmail.com','9876543229','Street 20',null,'Kolkata','West Bengal','700001'],

        ];

        foreach ($users as $u) {
            User::create([
                'name' => $u[0],
                'email' => $u[1],
                'phone' => $u[2],
                'address_line1' => $u[3],
                'address_line2' => $u[4],
                'city' => $u[5],
                'state' => $u[6],
                'postal_code' => $u[7],
                'password' => '12345678', // 
            ]);
        }
    }
}
