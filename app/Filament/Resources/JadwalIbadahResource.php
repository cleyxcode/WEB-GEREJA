<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JadwalIbadahResource\Pages;
use App\Models\JadwalIbadah;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class JadwalIbadahResource extends Resource
{
    protected static ?string $model = JadwalIbadah::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationLabel = 'Jadwal Ibadah';

    protected static ?string $pluralLabel = 'Jadwal Ibadah';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('tanggal')
                    ->label('Tanggal')
                    ->required()
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->rule('date')
                    ->rule(function () {
                        return function (string $attribute, $value, \Closure $fail) {
                            $date = \Carbon\Carbon::parse($value);
                            if ($date->dayOfWeek !== \Carbon\Carbon::SUNDAY) {
                                $fail('Tanggal harus hari Minggu.');
                            }
                        };
                    })
                    ->helperText('Harus hari Minggu'),

                Forms\Components\TimePicker::make('waktu')
                    ->label('Waktu')
                    ->required()
                    ->native(false)
                    ->seconds(false),

                Forms\Components\TextInput::make('tempat')
                    ->label('Tempat')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('petugas_ibadah')
                    ->label('Petugas Ibadah')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('liturgi_text')
                    ->label('Liturgi (Teks)')
                    ->rows(5)
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('liturgi_file')
                    ->label('Liturgi (File)')
                    ->disk('public')
                    ->directory('liturgi')
                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                    ->maxSize(5120)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('waktu')
                    ->label('Waktu')
                    ->time('H:i'),

                Tables\Columns\TextColumn::make('tempat')
                    ->label('Tempat')
                    ->searchable(),

                Tables\Columns\TextColumn::make('petugas_ibadah')
                    ->label('Petugas Ibadah')
                    ->searchable(),

                Tables\Columns\IconColumn::make('liturgi_file')
                    ->label('File Liturgi')
                    ->boolean()
                    ->trueIcon('heroicon-o-document-text')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('creator.name')
                    ->label('Dibuat Oleh')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            ])
            ->defaultSort('tanggal', 'desc');
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
            'index' => Pages\ListJadwalIbadahs::route('/'),
            'create' => Pages\CreateJadwalIbadah::route('/create'),
            'edit' => Pages\EditJadwalIbadah::route('/{record}/edit'),
        ];
    }
}