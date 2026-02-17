<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JemaatResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class JemaatResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Jemaat';

    protected static ?string $pluralLabel = 'Jemaat';

    protected static ?string $modelLabel = 'Jemaat';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('role', 'jemaat');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Akun')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create')
                            ->maxLength(255)
                            ->revealable()
                            ->helperText('Kosongkan jika tidak ingin mengubah password'),

                        Forms\Components\Hidden::make('role')
                            ->default('jemaat'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Informasi Kontak')
                    ->schema([
                        Forms\Components\TextInput::make('no_hp')
                            ->label('No. HP')
                            ->tel()
                            ->maxLength(20)
                            ->placeholder('08xxxxxxxxxx'),

                        Forms\Components\Textarea::make('alamat')
                            ->label('Alamat')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->icon('heroicon-o-envelope'),

                Tables\Columns\TextColumn::make('no_hp')
                    ->label('No. HP')
                    ->searchable()
                    ->icon('heroicon-o-phone')
                    ->placeholder('Belum diisi'),

                Tables\Columns\TextColumn::make('alamat')
                    ->label('Alamat')
                    ->limit(50)
                    ->searchable()
                    ->toggleable()
                    ->placeholder('Belum diisi'),

                Tables\Columns\TextColumn::make('pendaftaran_count')
                    ->label('Total Pendaftaran')
                    ->counts('pendaftaran')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('saran_count')
                    ->label('Total Saran')
                    ->counts('saran')
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Terdaftar Pada')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('has_phone')
                    ->label('Punya No. HP')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('no_hp')),

                Tables\Filters\Filter::make('has_address')
                    ->label('Punya Alamat')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('alamat')),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    
                    Tables\Actions\Action::make('view_pendaftaran')
                        ->label('Lihat Pendaftaran')
                        ->icon('heroicon-o-clipboard-document-list')
                        ->color('info')
                        ->url(fn (User $record): string => route('filament.admin.resources.pendaftarans.index', [
                            'tableFilters' => [
                                'user_id' => [
                                    'value' => $record->id,
                                ],
                            ],
                        ]))
                        ->visible(fn (User $record): bool => $record->pendaftaran_count > 0),

                    Tables\Actions\Action::make('view_saran')
                        ->label('Lihat Saran')
                        ->icon('heroicon-o-chat-bubble-left-right')
                        ->color('success')
                        ->url(fn (User $record): string => route('filament.admin.resources.sarans.index', [
                            'tableFilters' => [
                                'user_id' => [
                                    'value' => $record->id,
                                ],
                            ],
                        ]))
                        ->visible(fn (User $record): bool => $record->saran_count > 0),

                    Tables\Actions\DeleteAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Hapus Jemaat')
                        ->modalDescription('Apakah Anda yakin ingin menghapus jemaat ini? Data pendaftaran dan saran terkait akan ikut terhapus.')
                        ->modalSubmitActionLabel('Ya, Hapus'),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Hapus Jemaat Terpilih')
                        ->modalDescription('Apakah Anda yakin ingin menghapus jemaat terpilih? Data pendaftaran dan saran terkait akan ikut terhapus.')
                        ->modalSubmitActionLabel('Ya, Hapus'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListJemaats::route('/'),
            'create' => Pages\CreateJemaat::route('/create'),
            'edit' => Pages\EditJemaat::route('/{record}/edit'),
            'view' => Pages\ViewJemaat::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getEloquentQuery()->count();
    }
}