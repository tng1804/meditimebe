<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ScheduleTemplateGroup;
use App\Models\ScheduleTemplate;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::transaction(function () {
                // 1. Tạo nhóm mẫu lịch
                $templateGroup = ScheduleTemplateGroup::create([
                    'name' => 'Lịch tiêu chuẩn 8h-16h30'
                ]);

                // 2. Sinh bản ghi ScheduleTemplate cho các ngày Thứ 2-6
                $daysOfWeek = [2, 3, 4, 5, 6];
                $morningStart = Carbon::parse('08:00:00');
                $morningEnd = Carbon::parse('12:00:00');
                $afternoonStart = Carbon::parse('13:30:00');
                $afternoonEnd = Carbon::parse('16:30:00');

                $totalRecords = 0;
                foreach ($daysOfWeek as $dayOfWeek) {
                    // Buổi sáng (8:00 - 12:00)
                    $currentTime = $morningStart->copy();
                    $slotCount = 0;
                    while ($currentTime->lt($morningEnd)) {
                        $start = $currentTime->format('H:i:s');
                        $currentTime->addMinutes(30);
                        $end = $currentTime->format('H:i:s');

                        ScheduleTemplate::create([
                            'name' => 'Lịch tiêu chuẩn 8h-16h30',
                            'day_of_week' => $dayOfWeek,
                            'start_time' => $start,
                            'end_time' => $end,
                            'status' => 'available',
                            'template_group_id' => $templateGroup->id,
                        ]);
                        $slotCount++;
                        $totalRecords++;
                    }

                    // Buổi chiều (13:30 - 16:30)
                    $currentTime = $afternoonStart->copy();
                    while ($currentTime->lt($afternoonEnd)) {
                        $start = $currentTime->format('H:i:s');
                        $currentTime->addMinutes(30);
                        $end = $currentTime->format('H:i:s');

                        ScheduleTemplate::create([
                            'name' => 'Lịch tiêu chuẩn 8h-16h30',
                            'day_of_week' => $dayOfWeek,
                            'start_time' => $start,
                            'end_time' => $end,
                            'status' => 'available',
                            'template_group_id' => $templateGroup->id,
                        ]);
                        $slotCount++;
                        $totalRecords++;
                    }
                    Log::info("Day $dayOfWeek: $slotCount slots created");
                }
                Log::info("Total ScheduleTemplate records created: $totalRecords");

                // 3. Gán mẫu lịch cho nhiều bác sĩ
                $doctorIds = [1,2,3,4,5,6,7]; // Danh sách doctor_id, có thể thay đổi
                $doctorSchedules = [];
                foreach ($doctorIds as $doctorId) {
                    $doctorSchedules[] = [
                        'doctor_id' => $doctorId,
                        'schedule_template_id' => $templateGroup->id,
                    ];
                }
                DB::table('doctor_schedules')->insert($doctorSchedules);
                });
        } catch (\Exception $e) {
            Log::error('Lỗi khi chạy seeder: ' . $e->getMessage());
            throw $e;
        }
    }
}
