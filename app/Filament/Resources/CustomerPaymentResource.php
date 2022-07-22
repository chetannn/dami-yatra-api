<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerPaymentResource\Pages;
use App\Filament\Resources\CustomerPaymentResource\RelationManagers;
use App\Models\CustomerPayment;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class CustomerPaymentResource extends Resource
{
    protected static ?string $model = CustomerPayment::class;

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
                Tables\Columns\TextColumn::make('customer.name'),
                Tables\Columns\TextColumn::make('advertisement.title'),
                Tables\Columns\TextColumn::make('taxable_amount'),
                Tables\Columns\TextColumn::make('discount_amount'),
                Tables\Columns\TextColumn::make('total_amount_with_tax'),
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
            'index' => Pages\ListCustomerPayments::route('/'),
            'create' => Pages\CreateCustomerPayment::route('/create'),
            'edit' => Pages\EditCustomerPayment::route('/{record}/edit'),
        ];
    }
}
