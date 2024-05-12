<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use App\Models\Produk;
use Illuminate\Support\Number;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Shop';
    protected static ?int $navigationSort = 1;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Informasi Order')->schema([
                        Select::make('customer_id')
                            ->label('Customer')
                            ->relationship('customer', 'nama')
                            ->createOptionForm([
                            TextInput::make('nama')
                                ->maxLength(255)
                                ->required(),                             
                            ])
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('metode_pembayaran')
                        ->options([
                            'Cash' => 'Cash',
                            'Transfer' => 'Transfer',  
                        ])
                        ->native(false)
                        ->required(),

                        Select::make('status_pembayaran')
                        ->options([
                            'Lunas' => 'Lunas',
                            'Belum Lunas' => 'Belum Lunas',
                        ])
                        ->default('Belum Lunas')
                        ->native(false)
                        ->required(),

                        ToggleButtons::make('status')
                        ->inline()
                        ->default('New')
                        ->required()
                        ->options([
                            'New' => 'New',
                            'Completed' => 'Completed',
                            'Canceled' => 'Canceled',
                        ])
                        ->colors([
                            'New' => 'info',
                            'Completed' => 'success',
                            'Canceled' => 'danger',
                        ])
                        ->icons([
                            'New' => 'heroicon-m-sparkles',
                            'Completed' => 'heroicon-m-check-badge',
                            'Canceled' => 'heroicon-m-x-circle',
                        ])
                    ])->columns(2),

                    Section::make('Order Items')->schema([
                        Repeater::make('items')
                        ->relationship()
                        ->schema([
                            
                            Select::make('product_id')
                            ->relationship('produk', 'nama_produk')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->distinct()
                            ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                            ->columnSpan(4)
                            ->reactive()
                            ->afterStateUpdated(fn ($state, Set $set) => $set('unit_amount', Produk::find($state)?->harga ?? 0))
                            ->afterStateUpdated(fn ($state, Set $set) => $set('total_amount', Produk::find($state)?->harga ?? 0))
                            ,

                            TextInput::make('quantity')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->required()
                            ->columnSpan(2)
                            ->reactive()
                            ->afterStateUpdated(fn ($state, Set $set, Get $get) => $set('total_amount', $state * $get('unit_amount')))
                            ,

                            TextInput::make('unit_amount')
                            ->numeric()
                            ->disabled()
                            ->required()
                            ->dehydrated()
                            ->columnSpan(3),

                            TextInput::make('total_amount')
                            ->numeric()
                            ->required()
                            ->dehydrated()
                            ->columnSpan(3),
                        ])->columns(12),

                        Placeholder::make('grand_total_placeholder')
                        ->label('Grand Total')
                        ->content(function (Get $get, Set $set) {
                            $total = 0;
                            if(!$repeaters = $get('items')) {
                                return $total;
                            }

                            foreach ($repeaters as $key => $repeater) {
                                $total += $get("items.{$key}.total_amount");
                            }

                            $set('grand_total', $total);
                            return Number::currency($total, 'Rp.');
                        }),
                        
                        Hidden::make('grand_total')
                        ->default(0)
                    ])

                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
