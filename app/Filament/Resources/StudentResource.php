<?php

namespace App\Filament\Resources;

use App\Exports\StudentsExport;
use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Http\Controllers\StudentsController;
use App\Models\Classroom;
use App\Models\Section;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Collection;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('names')
                    ->placeholder('student names')
                    ->required(),

                TextInput::make('address')
                    ->placeholder('student names')
                    ->required(),

                Select::make('classroom_id')
                    ->relationship('classroom', 'name')
                    ->reactive(),

                Select::make('section_id')
                    ->label('Section')
                    ->options(function (callable $get) {
                        $classId = $get('classroom_id');

                        if ($classId) {
                            return Section::where('classroom_id', $classId)->pluck('name', 'id')->toArray();
                        }
                    })

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('names')
                    ->sortable(),

                TextColumn::make('address')
                    ->sortable(),

                TextColumn::make('classroom.name')
                    ->sortable(),

                TextColumn::make('section.name')
                    ->sortable()
            ])
            ->filters([
                Filter::make('students_filter')
                    ->form([
                        Select::make('classroom_id')
                            ->label('Filter by classroom')
                            ->placeholder('select a classroom')
                            ->options(Classroom::pluck('name', 'id')->toArray())
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['classroom_id'],
                                fn (Builder $query, $record): Builder => $query->where('classroom_id', $record),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                BulkAction::make('export')
                    ->icon('heroicon-o-document-download')
                    ->action(fn (Collection $students) => (new StudentsExport($students))->download('students.xlsx'))
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
