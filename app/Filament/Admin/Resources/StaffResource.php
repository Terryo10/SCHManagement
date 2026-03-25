<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\StaffResource\Pages;
use App\Models\School;
use App\Models\Staff;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class StaffResource extends Resource
{
    protected static ?string $model = Staff::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'Staff';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Staff Account')->schema([
                Forms\Components\Select::make('school_id')
                    ->label('School')
                    ->options(School::pluck('name', 'id'))
                    ->required()->searchable(),
                Forms\Components\TextInput::make('staff_number')
                    ->required()->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('user.name')
                    ->label('Full Name')->required(),
                Forms\Components\TextInput::make('user.email')
                    ->label('Email')->email()->required(),
                Forms\Components\TextInput::make('user.password')
                    ->label('Password')->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context) => $context === 'create'),
            ])->columns(2),

            Forms\Components\Section::make('Employment Details')->schema([
                Forms\Components\TextInput::make('designation')->required(),
                Forms\Components\TextInput::make('department'),
                Forms\Components\DatePicker::make('joining_date')->required(),
                Forms\Components\Select::make('employment_type')
                    ->options([
                        'full_time'  => 'Full Time',
                        'part_time'  => 'Part Time',
                        'contract'   => 'Contract',
                        'volunteer'  => 'Volunteer',
                    ])->default('full_time'),
                Forms\Components\TextInput::make('qualification'),
                Forms\Components\TextInput::make('basic_salary')
                    ->numeric()->prefix('R'),
                Forms\Components\Toggle::make('is_teacher')
                    ->label('Is a Teacher'),
                Forms\Components\Select::make('status')
                    ->options(['active' => 'Active', 'inactive' => 'Inactive', 'terminated' => 'Terminated'])
                    ->default('active'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('staff_number')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('user.name')->label('Name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('designation')->searchable(),
                Tables\Columns\TextColumn::make('department'),
                Tables\Columns\TextColumn::make('employment_type')->badge(),
                Tables\Columns\IconColumn::make('is_teacher')->boolean()->label('Teacher'),
                Tables\Columns\TextColumn::make('status')->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active'     => 'success',
                        'inactive'   => 'gray',
                        'terminated' => 'danger',
                        default      => 'gray',
                    }),
                Tables\Columns\TextColumn::make('basic_salary')->money('ZAR')->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(['active' => 'Active', 'inactive' => 'Inactive', 'terminated' => 'Terminated']),
                Tables\Filters\TernaryFilter::make('is_teacher')->label('Teachers Only'),
                Tables\Filters\SelectFilter::make('school')->relationship('school', 'name'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index'  => Pages\ListStaff::route('/'),
            'create' => Pages\CreateStaff::route('/create'),
            'edit'   => Pages\EditStaff::route('/{record}/edit'),
            'view'   => Pages\ViewStaff::route('/{record}'),
        ];
    }
}
