<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrderStatus;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['id' => 1, 'name' => 'Pending'],
            ['id' => 2, 'name' => 'Confirmed'],
            ['id' => 3, 'name' => 'Processing'],
            ['id' => 4, 'name' => 'Shipped'],
            ['id' => 5, 'name' => 'Out for Delivery'],
            ['id' => 6, 'name' => 'Delivered'],
            ['id' => 7, 'name' => 'Cancelled'],
            ['id' => 8, 'name' => 'Refunded'],
            ['id' => 9, 'name' => 'Failed'],
            ['id' => 10, 'name' => 'On Hold'],
        ];

        foreach ($statuses as $status) {
            OrderStatus::updateOrCreate(
                ['id' => $status['id']],
                ['name' => $status['name']]
            );
        }
    }
}
