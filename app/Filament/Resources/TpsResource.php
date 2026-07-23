<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TpsResource\Pages;
use App\Models\Tps;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use UnitEnum;
use BackedEnum;

class TpsResource extends Resource
{
    protected static ?string $model = Tps::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-building-office-2';

    protected static string | UnitEnum | null $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Data TPS';

    protected static ?string $modelLabel = 'TPS';

    protected static ?string $pluralModelLabel = 'Data TPS';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('nomor_tps')
                    ->label('Nomor TPS')
                    ->required()
                    ->maxLength(10)
                    ->placeholder('Contoh: TPS 001'),

                Forms\Components\TextInput::make('nama_lokasi')
                    ->label('Nama Lokasi / Tempat')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Contoh: SD Negeri 1 Pikat'),

                Forms\Components\TextInput::make('dusun')
                    ->label('Banjar / Dusun')
                    ->maxLength(255)
                    ->placeholder('Contoh: Banjar Pikat'),

                Forms\Components\TextInput::make('kuota_pemilih')
                    ->label('Kuota Pemilih')
                    ->numeric()
                    ->default(0)
                    ->suffix('Orang'),

                Forms\Components\Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor_tps')
                    ->label('Nomor TPS')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('nama_lokasi')
                    ->label('Nama Lokasi')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('dusun')
                    ->label('Banjar / Dusun')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('voters_count')
                    ->label('Jumlah Pemilih')
                    ->counts('voters')
                    ->badge()
                    ->color('success')
                    ->sortable(),

                Tables\Columns\TextColumn::make('kuota_pemilih')
                    ->label('Kuota')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y, H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('dusun')
                    ->label('Filter Dusun')
                    ->options(fn () => Tps::whereNotNull('dusun')->pluck('dusun', 'dusun')->toArray()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn () => auth()->user()?->isAdmin()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => auth()->user()?->isAdmin()),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTps::route('/'),
            'create' => Pages\CreateTps::route('/create'),
            'edit' => Pages\EditTps::route('/{record}/edit'),
        ];
    }
}
