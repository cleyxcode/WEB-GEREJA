<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaranResource\Pages;
use App\Models\Saran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class SaranResource extends Resource
{
    protected static ?string $model = Saran::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationLabel = 'Saran';

    protected static ?string $pluralLabel = 'Saran';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Pengirim')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('isi_saran')
                    ->label('Isi Saran')
                    ->required()
                    ->rows(5)
                    ->columnSpanFull(),

                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'baru' => 'Baru',
                        'dibaca' => 'Dibaca',
                        'ditindaklanjuti' => 'Ditindaklanjuti',
                    ])
                    ->default('baru')
                    ->required()
                    ->native(false)
                    ->hiddenOn('create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pengirim')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('user.no_hp')
                    ->label('No. HP')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('isi_saran')
                    ->label('Isi Saran')
                    ->limit(80)
                    ->wrap()
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'info' => 'baru',
                        'warning' => 'dibaca',
                        'success' => 'ditindaklanjuti',
                    ])
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diupdate')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'baru' => 'Baru',
                        'dibaca' => 'Dibaca',
                        'ditindaklanjuti' => 'Ditindaklanjuti',
                    ]),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    
                    Tables\Actions\Action::make('mark_as_read')
                        ->label('Tandai Dibaca')
                        ->icon('heroicon-o-eye')
                        ->color('warning')
                        ->visible(fn (Saran $record): bool => $record->status === 'baru')
                        ->action(function (Saran $record) {
                            $record->update(['status' => 'dibaca']);
                            
                            Notification::make()
                                ->success()
                                ->title('Status Diupdate')
                                ->body('Saran telah ditandai sebagai dibaca.')
                                ->send();
                        }),

                    Tables\Actions\Action::make('mark_as_followed_up')
                        ->label('Tandai Ditindaklanjuti')
                        ->icon('heroicon-o-check-badge')
                        ->color('success')
                        ->visible(fn (Saran $record): bool => in_array($record->status, ['baru', 'dibaca']))
                        ->action(function (Saran $record) {
                            $record->update(['status' => 'ditindaklanjuti']);
                            
                            Notification::make()
                                ->success()
                                ->title('Status Diupdate')
                                ->body('Saran telah ditandai sebagai ditindaklanjuti.')
                                ->send();
                        }),

                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    Tables\Actions\BulkAction::make('mark_as_read_bulk')
                        ->label('Tandai Dibaca')
                        ->icon('heroicon-o-eye')
                        ->color('warning')
                        ->action(function ($records) {
                            $records->each->update(['status' => 'dibaca']);
                            
                            Notification::make()
                                ->success()
                                ->title('Status Diupdate')
                                ->body(count($records) . ' saran telah ditandai sebagai dibaca.')
                                ->send();
                        }),

                    Tables\Actions\BulkAction::make('mark_as_followed_up_bulk')
                        ->label('Tandai Ditindaklanjuti')
                        ->icon('heroicon-o-check-badge')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each->update(['status' => 'ditindaklanjuti']);
                            
                            Notification::make()
                                ->success()
                                ->title('Status Diupdate')
                                ->body(count($records) . ' saran telah ditandai sebagai ditindaklanjuti.')
                                ->send();
                        }),
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
            'index' => Pages\ListSarans::route('/'),
            'create' => Pages\CreateSaran::route('/create'),
            'edit' => Pages\EditSaran::route('/{record}/edit'),
            
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'baru')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::where('status', 'baru')->count() > 0 ? 'info' : 'success';
    }
}