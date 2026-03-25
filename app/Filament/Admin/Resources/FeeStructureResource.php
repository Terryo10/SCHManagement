<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\FeeStructureResource\Pages;
use App\Models\AcademicYear;
use App\Models\FeeStructure;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Term;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FeeStructureResource extends Resource
{
    protected static ?string $model = FeeStructure::class;
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Finance';
    protected static ?string $navigationLabel = 'Fee Structures';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('school_id')
                ->label('School')
                ->options(School::pluck('name', 'id'))
                ->required()->searchable()->reactive(),
            Forms\Components\Select::make('academic_year_id')
                ->label('Academic Year')
                ->options(AcademicYear::pluck('name', 'id'))
                ->required()->searchable(),
            Forms\Components\Select::make('term_id')
                ->label('Term (optional)')
                ->options(Term::pluck('name', 'id'))
                ->searchable()->nullable(),
            Forms\Components\Select::make('school_class_id')
                ->label('Class (leave blank for all classes)')
                ->options(SchoolClass::pluck('name', 'id'))
                ->searchable()->nullable(),
            Forms\Components\TextInput::make('name')
                ->required()->placeholder('e.g. Tuition Fee, Library Fee'),
            Forms\Components\TextInput::make('amount')
                ->numeric()->prefix('R')->required(),
            Forms\Components\Select::make('frequency')
                ->options([
                    'once'     => 'Once',
                    'monthly'  => 'Monthly',
                    'termly'   => 'Per Term',
                    'annually' => 'Annually',
                ])->required(),
            Forms\Components\DatePicker::make('due_date'),
            Forms\Components\Toggle::make('is_active')->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('school.name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('schoolClass.name')->label('Class')->default('All Classes'),
                Tables\Columns\TextColumn::make('academicYear.name')->label('Year'),
                Tables\Columns\TextColumn::make('amount')->money('ZAR')->sortable(),
                Tables\Columns\TextColumn::make('frequency')->badge(),
                Tables\Columns\TextColumn::make('due_date')->date(),
                Tables\Columns\IconColumn::make('is_active')->boolean()->label('Active'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
                Tables\Filters\SelectFilter::make('school')->relationship('school', 'name'),
                Tables\Filters\SelectFilter::make('academic_year')->relationship('academicYear', 'name'),
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
            'index'  => Pages\ListFeeStructures::route('/'),
            'create' => Pages\CreateFeeStructure::route('/create'),
            'edit'   => Pages\EditFeeStructure::route('/{record}/edit'),
        ];
    }
}
