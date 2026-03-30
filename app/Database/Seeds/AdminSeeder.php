<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'name'       => 'Super Admin',
            'email'      => 'admin@pacudans.com',
            'password'   => password_hash('admin12345', PASSWORD_DEFAULT),
            'role'       => 'admin',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Check if admin already exists
        $exists = $this->db->table('users')->where('email', 'admin@pacudans.com')->get()->getRow();

        if (!$exists) {
            $this->db->table('users')->insert($data);
        } else {
            $this->db->table('users')->where('email', 'admin@pacudans.com')->update($data);
        }
    }
}
