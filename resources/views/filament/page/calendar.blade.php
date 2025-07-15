<x-filament-panels::page>
    <x-filament::input.wrapper>
        <x-filament::input.select wire:model.live="selectedSchedule">
            @foreach ($schedules as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </x-filament::input.select>
    </x-filament::input.wrapper>

    @livewire(
        \App\Filament\Widgets\MyCalendarWidget::class,
        [
            'selectedSchedule' => $selectedSchedule,
        ],
        key(str()->random())
    )
</x-filament-panels::page>
