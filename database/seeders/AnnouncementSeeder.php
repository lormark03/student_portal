<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Announcement::create([
            'title' => 'Welcome to Student Portal',
            'body' => "System maintenance is scheduled for next Sunday 2:00 AM - 4:00 AM. Please save your work.",
            'is_active' => true,
            'user_id' => null,
        ]);
    }
}
