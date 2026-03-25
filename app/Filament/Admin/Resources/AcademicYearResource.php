<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AcademicYearResource\Pages;
use App\Models\AcademicYear;
use App\Models\School;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AcademicYearResource extends Resource
{
    protected static ?string $model = AcademicYear::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationGroup = 'School Setup';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('school_id')
                ->label('School')
                ->options(School::pluck('name', 'id'))
                ->required()->searchable(),
            Forms\Components\TextInput::make('name')
                ->required()->placeholder('e.g. 2025/2026'),
            Forms\Components\DatePicker::make('start_date')->required(),
            Forms\Components\DatePicker::make('end_date')->required(),
            Forms\Components\Toggle::make('is_current')
                ->label('Current Year')
                ->helperText('Only one academic year should be current.'),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('school.name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('start_date')->date(),
                Tables\Columns\TextColumn::make('end_date')->date(),
                Tables\Columns\IconColumn::make('is_current')->boolean()->label('Current'),
                Tables\Columns\TextColumn::make('terms_count')->counts('terms')->label('Terms'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_current')->label('Current Year'),
                Tables\Filters\SelectFilter::make('school')->relationship('school', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListAcademicYears::route('/'),
            'create' => Pages\CreateAcademicYear::route('/create'),
            'edit'   => Pages\EditAcademicYear::route('/{record}/edit'),
        ];
    }
}
