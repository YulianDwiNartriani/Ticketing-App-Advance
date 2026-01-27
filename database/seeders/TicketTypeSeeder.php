<?php

namespace Database\Seeders;

use App\Models\TicketType;
use Illuminate\Database\Seeder;

class TicketTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ticketTypes = [
            ['nama_tipe' => 'Reguler'],
            ['nama_tipe' => 'Premium'],
            ['nama_tipe' => 'VIP'],
        ];

        foreach ($ticketTypes as $type) {
            TicketType::create([
                'nama' => $type['nama_tipe'],
            ]);
        }
    }
}
