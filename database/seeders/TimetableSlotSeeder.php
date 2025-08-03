<?php

namespace Database\Seeders;

use App\Models\Batch;
use App\Models\Module;
use App\Models\Schedule;
use App\Models\Timetable;
use App\Models\TimetableSlot;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimetableSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $days = collect(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']);

        for ($i = 1; $i <= 5; $i++) {
            $availableDays = $days->shuffle();

            $timetable = Timetable::create([
                'name'       => 'Avenger ' . $i,
                'start_date' => Carbon::parse('2025-07-29')->addWeeks($i - 1),
                'end_date'   => Carbon::parse('2025-10-21')->addWeeks($i - 1),
                'batch_id'   => Batch::inRandomOrder()->first()->id,
            ]);

            for ($j = 0; $j < 3; $j++) {
                printf($j);
                TimetableSlot::create([
                    'timetable_id' => $timetable->id,
                    'module_id'    => Module::inRandomOrder()->first()->id, // or use random if needed
                    'day_of_week'  => $availableDays[$j],
                    'start_time'   => now()->setTime(18, 0)->addMinutes($j * 10),
                    'end_time'     => now()->setTime(20, 0)->addMinutes($j * 10),
                ]);
            }
        }

        foreach (TimetableSlot::all() as $slot) {
            Schedule::create([
                'timetable_slot_id' => $slot->id,
                'module_id'         => $slot->module_id,
                'start_at'          => Carbon::parse('2025-07-29 17:56:53'),
                'end_at'            => Carbon::parse('2025-07-29 19:56:57'),
            ]);
        }
    }
}
