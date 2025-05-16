<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengambalianResource\Pages;
use App\Filament\Resources\PengambalianResource\RelationManagers;
use App\Models\Pengembalian;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PengambalianResource extends Resource
{
    protected static ?string $model = Pengembalian::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Pengembalian Barang';

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

                Forms\Components\DatePicker::make('tanggal_pengembalian')
                    ->label('Tanggal Pengembalian')
                    ->required(),

                Forms\Components\Select::make('kondisi_barang')
                    ->label('Kondisi Barang')
                    ->options([
                        'baik' => 'Baik',
                        'rusak' => 'Rusak',
                        'hilang' => 'Hilang',
                    ])
                    ->required(),

                Forms\Components\Textarea::make('catatan')
                    ->label('Catatan')
                    ->rows(3)
                    ->maxLength(500),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('peminjaman.user.name')
                    ->label('Peminjam'),

                Tables\Columns\TextColumn::make('tanggal_pengembalian')
                    ->label('Tanggal Kembali')
                    ->date('d M Y'),

                Tables\Columns\BadgeColumn::make('kondisi_barang')
                    ->label('Kondisi')
                    ->colors([
                        'success' => 'baik',
                        'warning' => 'rusak',
                        'danger' => 'hilang',
                    ]),

                Tables\Columns\TextColumn::make('catatan')
                    ->label('Catatan')
                    ->limit(30)
                    ->wrap(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->since(),
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
            'index' => Pages\ListPengambalians::route('/'),
            'create' => Pages\CreatePengambalian::route('/create'),
            'edit' => Pages\EditPengambalian::route('/{record}/edit'),
        ];
    }
}
