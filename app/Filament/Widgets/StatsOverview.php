<?php

namespace App\Filament\Widgets;

use App\Models\Classroom;
use App\Models\Section;
use App\Models\Student;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected static ? int $sort = 1; 
    protected function getCards(): array
    {
        return [
            Card::make('Total students', Student::count()),
            Card::make('Total Sections', Section::count()),
            Card::make('Total Classes', Classroom::count()),
        ];
    }
}
