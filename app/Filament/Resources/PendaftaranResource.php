<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendaftaranResource\Pages;
use App\Models\Pendaftaran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class PendaftaranResource extends Resource
{
    protected static ?string $model = Pendaftaran::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Pendaftaran';
    protected static ?string $pluralLabel = 'Pendaftaran';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Data Pendaftar')
                ->schema([
                    Forms\Components\Select::make('user_id')
                        ->label('Akun Jemaat')
                        ->relationship('user', 'name')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('nama')
                        ->label('Nama Lengkap')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Forms\Components\Select::make('jenis')
                        ->label('Jenis Layanan')
                        ->options([
                            'baptis' => 'Baptis Kudus',
                            'sidi'   => 'Sidi (Peneguhan)',
                            'nikah'  => 'Pemberkatan Nikah',
                        ])
                        ->required()
                        ->native(false),

                    Forms\Components\DatePicker::make('tanggal_daftar')
                        ->label('Tanggal Pelaksanaan')
                        ->required()
                        ->native(false)
                        ->displayFormat('d/m/Y'),

                    Forms\Components\Select::make('status')
                        ->label('Status')
                        ->options([
                            'pending'   => 'Pending',
                            'disetujui' => 'Disetujui',
                            'ditolak'   => 'Ditolak',
                        ])
                        ->default('pending')
                        ->required()
                        ->native(false)
                        ->hiddenOn('create'),

                    Forms\Components\Textarea::make('catatan')
                        ->label('Catatan')
                        ->nullable()
                        ->columnSpanFull(),
                ])->columns(2),

            Forms\Components\Section::make('Foto Dokumen')
                ->schema([
                    Forms\Components\FileUpload::make('foto')
                        ->label('Foto')
                        ->image()
                        ->disk('public')
                        ->directory('pendaftaran/foto')
                        ->nullable()
                        ->imagePreviewHeight('250')
                        ->downloadable()
                        ->openable()
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Akun')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('jenis')
                    ->label('Jenis')
                    ->badge()
                    ->color(fn (string $state): string => match($state) {
                        'baptis' => 'warning',
                        'sidi'   => 'info',
                        'nikah'  => 'pink',
                        default  => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'baptis' => 'Baptis Kudus',
                        'sidi'   => 'Sidi (Peneguhan)',
                        'nikah'  => 'Pemberkatan Nikah',
                        default  => ucfirst($state),
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal_daftar')
                    ->label('Tgl Pelaksanaan')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\ImageColumn::make('foto')
                    ->label('Foto')
                    ->disk('public')
                    ->width(50)
                    ->height(50)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('catatan')
                    ->label('Catatan')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match($state) {
                        'pending'   => 'warning',
                        'disetujui' => 'success',
                        'ditolak'   => 'danger',
                        default     => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenis')
                    ->options([
                        'baptis' => 'Baptis Kudus',
                        'sidi'   => 'Sidi (Peneguhan)',
                        'nikah'  => 'Pemberkatan Nikah',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending'   => 'Pending',
                        'disetujui' => 'Disetujui',
                        'ditolak'   => 'Ditolak',
                    ]),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),

                    Tables\Actions\Action::make('approve')
                        ->label('Setujui')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Setujui Pendaftaran')
                        ->modalDescription('Apakah Anda yakin ingin menyetujui pendaftaran ini?')
                        ->visible(fn (Pendaftaran $record): bool => $record->status === 'pending')
                        ->action(function (Pendaftaran $record) {
                            $record->update(['status' => 'disetujui']);
                            Notification::make()->success()
                                ->title('Pendaftaran Disetujui')
                                ->body('Pendaftaran atas nama ' . $record->nama . ' telah disetujui.')
                                ->send();
                        }),

                    Tables\Actions\Action::make('reject')
                        ->label('Tolak')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Tolak Pendaftaran')
                        ->modalDescription('Apakah Anda yakin ingin menolak pendaftaran ini?')
                        ->visible(fn (Pendaftaran $record): bool => $record->status === 'pending')
                        ->action(function (Pendaftaran $record) {
                            $record->update(['status' => 'ditolak']);
                            Notification::make()->warning()
                                ->title('Pendaftaran Ditolak')
                                ->body('Pendaftaran atas nama ' . $record->nama . ' telah ditolak.')
                                ->send();
                        }),

                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    Tables\Actions\BulkAction::make('approve_bulk')
                        ->label('Setujui Terpilih')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $records->each->update(['status' => 'disetujui']);
                            Notification::make()->success()
                                ->title($records->count() . ' pendaftaran telah disetujui.')
                                ->send();
                        }),

                    Tables\Actions\BulkAction::make('reject_bulk')
                        ->label('Tolak Terpilih')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $records->each->update(['status' => 'ditolak']);
                            Notification::make()->warning()
                                ->title($records->count() . ' pendaftaran telah ditolak.')
                                ->send();
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array { return []; }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPendaftarans::route('/'),
            'create' => Pages\CreatePendaftaran::route('/create'),
            'edit'   => Pages\EditPendaftaran::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }
}