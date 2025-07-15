<?php



namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CropsTableSeeder extends Seeder
{
    public function run(): void
    {
        // Sample: get existing foreign keys (make sure these IDs exist)
        $userId = DB::table('users')->value('id');
        $regionId = DB::table('regions')->value('id');
        $cropTypeId = DB::table('crop_types')->value('id');

        // Guard: Don't insert if foreign keys missing
        if (!$userId || !$regionId || !$cropTypeId) {
            $this->command->warn('Skipping crops seeder: missing user, region, or crop_type.');
            return;
        }

        DB::table('crops')->insert([
            [
                'name' => 'Maize',
                'crop_type_id' => $cropTypeId,
                'user_id' => $userId,
                'region_id' => $regionId,
                'image' => 'maize.jpg',
                'description' => 'A common cereal crop grown widely in East Africa.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tomato',
                'crop_type_id' => $cropTypeId,
                'user_id' => $userId,
                'region_id' => $regionId,
                'image' => 'tomato.jpg',
                'description' => 'Fresh tomato crop for market distribution.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

