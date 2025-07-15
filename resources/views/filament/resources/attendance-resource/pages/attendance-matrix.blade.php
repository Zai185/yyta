<x-filament::page>
    <form wire:submit.prevent="saveAttendance" class="space-y-6">
        <h2 class="text-xl font-bold mb-4">
            Attendance for {{ $selectedSchedule->module->name }} — {{ $selectedSchedule->start_at->format('D H:i') }} to {{ $selectedSchedule->end_at->format('H:i') }}
        </h2>

        <table class="table-auto w-full text-left border">
            <thead>
                <tr>
                    <th class="px-4 py-2">Student Name</th>
                    <th class="px-4 py-2">Present</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($selectedSchedule->module->students as $student)
                    <tr>
                        <td class="border px-4 py-2">{{ $student->name }}</td>
                        <td class="border px-4 py-2">
                            <x-forms::checkbox wire:model.defer="attendanceMatrix.{{ $student->id }}" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <x-filament::button type="submit">
            Save Attendance
        </x-filament::button>
    </form>
</x-filament::page>
