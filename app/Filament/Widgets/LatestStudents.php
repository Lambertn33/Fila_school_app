<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use Closure;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;

class LatestStudents extends BaseWidget
{
    protected static ? int $sort = 2;

    protected int | string | array $columnSpan = 'full';
     
    protected function getTableQuery(): Builder
    {
        return Student::query()->latest()->take(4);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('names')
                ->sortable(),

            TextColumn::make('address')
                ->sortable(),

            TextColumn::make('classroom.name')
                ->sortable(),

            TextColumn::make('section.name')
                ->sortable()
        ];
    }

    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }
}
