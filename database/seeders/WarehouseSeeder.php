<?php

namespace Database\Seeders;

use App\Models\Box;
use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fruitTypes = ['apples', 'pears', 'oranges'];

        foreach (range(1, 5) as $i) {
            $room = Room::create([
                'name' => "Room №{$i}",
            ]);

            foreach ($fruitTypes as $fruit) {
                if (rand(0, 1)) {
                    Box::create([
                        'fruit_type' => $fruit,
                        'box_count' => rand(1, 20),
                        'room_id' => $room->id,
                    ]);
                }
            }
        }
    }
}
