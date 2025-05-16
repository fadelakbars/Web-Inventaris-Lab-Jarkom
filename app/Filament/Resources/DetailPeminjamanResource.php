<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DetailPeminjamanResource\Pages;
use App\Filament\Resources\DetailPeminjamanResource\RelationManagers;
use App\Models\DetailPeminjaman;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DetailPeminjamanResource extends Resource
{
    protected static ?string $model = DetailPeminjaman::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Detail Peminjaman Barang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\Select::make('peminjaman_id')
                    ->label('ID Peminjaman')
                    ->relationship('peminjaman', 'id')
                    ->required()
                    ->searchable(),

                Forms\Components\Select::make('barang_id')
                    ->label('Nama Barang')
                    ->relationship('barang', 'nama_barang')
                    ->required()
                    ->searchable(),

                Forms\Components\TextInput::make('jumlah_pinjam')
                    ->label('Jumlah Pinjam')
                    ->required()
                    ->numeric()
                    ->minValue(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('peminjaman.id')
                    ->label('ID Peminjaman')
                    ->sortable(),

                Tables\Columns\TextColumn::make('barang.nama_barang')
                    ->label('Nama Barang')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('jumlah_pinjam')
                    ->label('Jumlah')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ditambahkan')
                    ->since(),
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListDetailPeminjamen::route('/'),
            'create' => Pages\CreateDetailPeminjaman::route('/create'),
            'edit' => Pages\EditDetailPeminjaman::route('/{record}/edit'),
        ];
    }
}
