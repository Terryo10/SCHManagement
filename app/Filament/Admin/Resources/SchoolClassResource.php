<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SchoolClassResource\Pages;
use App\Models\School;
use App\Models\SchoolClass;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SchoolClassResource extends Resource
{
    protected static ?string $model = SchoolClass::class;
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $navigationGroup = 'Academics';
    protected static ?string $navigationLabel = 'Classes';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('school_id')
                ->label('School')
                ->options(School::pluck('name', 'id'))
                ->required()->searchable(),
            Forms\Components\TextInput::make('name')
                ->required()->placeholder('e.g. Grade 1, Form 1'),
            Forms\Components\TextInput::make('order_index')
                ->numeric()->default(0)->label('Sort Order'),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('school.name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('order_index')->label('Order')->sortable(),
            ])
            ->defaultSort('order_index')
            ->filters([
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
            'index'  => Pages\ListSchoolClasses::route('/'),
            'create' => Pages\CreateSchoolClass::route('/create'),
            'edit'   => Pages\EditSchoolClass::route('/{record}/edit'),
        ];
    }
}
