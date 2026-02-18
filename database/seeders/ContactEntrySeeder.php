<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContactEntry;

class ContactEntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactEntry::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Inquiry about Order #123',
            'message' => 'Hi, I would like to know the status of my order.',
            'is_read' => false,
        ]);

        ContactEntry::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'subject' => 'Product Availability',
            'message' => 'When will the Luxury Gold Watch be back in stock?',
            'is_read' => true,
        ]);
    }
}
