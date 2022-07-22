<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VendorPaymentResource\Pages;
use App\Filament\Resources\VendorPaymentResource\RelationManagers;
use App\Models\VendorPayment;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class VendorPaymentResource extends Resource
{
    protected static ?string $model = VendorPayment::class;

    protected static ?string $navigationIcon = 'heroicon-o-cash';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('vendor.name'),
                Tables\Columns\TextColumn::make('advertisement.name'),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('amount'),
                Tables\Columns\TextColumn::make('status'),
                ])
            ->filters([
                //
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
            'index' => Pages\ListVendorPayments::route('/'),
            'create' => Pages\CreateVendorPayment::route('/create'),
            'edit' => Pages\EditVendorPayment::route('/{record}/edit'),
        ];
    }
}
