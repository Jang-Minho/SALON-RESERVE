<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;

class BirthDateSelect extends Component
{
    public string $birthYear = '';
    public string $birthMonth = '';
    public string $birthDay = '';

    public function getYearsProperty(): array
    {
        $thisYear = now()->year;
        return range($thisYear, 1900);
    }

    public function getMonthsProperty(): array
    {
        return range(1, 12);
    }

    public function getDaysProperty(): array
    {
        if ($this->birthYear === '' || $this->birthMonth === '') {
            return [];
        }
        $y = (int)$this->birthYear;
        $m = (int)$this->birthMonth;

        $lastDay = Carbon::create($y, $m, 1)->endOfMonth()->day;
        return range(1, $lastDay);
    }



    public function render()
    {
        return view('livewire.birth-date-select', [
            'years' => $this->years,
            'months' => $this->months,
            'days' => $this->days,
        ]);
    }
}
