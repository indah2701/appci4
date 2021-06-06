<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class OrangSeeder extends Seeder
{
    public function run()
    {
        // $data = [
        //     [
        //         'nama'       => 'Indah Sri Mulyati',
        //         'alamat'     => 'Desa Sukodadi-Paiton',
        //         'created_at' => Time::now(),
        //         'updated_at' => Time::now(),
        //     ],
        //     [
        //         'nama'       => 'Samsudin',
        //         'alamat'     => 'Desa Taman-Paiton',
        //         'created_at' => Time::now(),
        //         'updated_at' => Time::now(),
        //     ],
        //     [
        //         'nama'       => 'Rita Dwi Wahyuni',
        //         'alamat'     => 'Desa Ketompen-Pajarakan',
        //         'created_at' => Time::now(),
        //         'updated_at' => Time::now(),
        //     ],
        // ];

        // ja_JP = orang Jepang
        // fr_FR = orang Prancis
        // id_ID = orang Indonesia
        $faker = \Faker\Factory::create('id_ID');
        for ($i = 0; $i < 100; $i++) {
            $data = [
                'nama'       => $faker->name,
                'alamat'     => $faker->address,
                'created_at' => Time::createFromTimestamp($faker->unixTime()),
                // 'created_at' => Time::now(),
                'updated_at' => Time::now()
            ];
            $this->db->table('orang')->insert($data);
        }

        // Simple Queries
        // $this->db->query("INSERT INTO orang (nama, alamat, created_at, updated_at) VALUES(:nama:, :alamat:, :created_at:, :updated_at:)", $data);

        // // Using Query Builder

        // $this->db->table('orang')->insertBatch($data);
    }
}
