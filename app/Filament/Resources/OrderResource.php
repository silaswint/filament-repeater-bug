<?php

namespace App\Filament\Resources;

use App\Filament\Heroicons\Heroicon;
use App\Filament\Traits\Resource\HasLabel;
use App\Helper\FilamentComponentAddress\FilamentComponentAddress;
use App\Models\Order;
use Closure;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use App\Filament\Resources\OrderResource\Pages;

class OrderResource extends Resource
{
    use HasLabel;

    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = Heroicon::ORDER;

    public static function getNavigationGroup(): ?string
    {
        return 'Orders';
    }

    public static function warehousesStep()
    {
        $defaultWarehouses = [
            [
                'id' => 1,
                'name' => 'Reinhardt Stahl KG',
                'city' => 'Wittenberg',
                'price_per_pallet_inbound' => 2.96,
                'price_per_day_storage' => 4.98,
                'price_per_pallet_outbound' => 2.2,
                'max_pallet_height_in_rack_storage' => 239,
                'max_pallet_weight_in_rack_storage' => 326,
                'max_pallet_length_in_rack_storage' => 1200,
                'max_pallet_width_in_rack_storage' => 800,
                'max_pallet_positions' => 78,
                'transportation_requested' => false,
                'transportation_provider' => 'superlogistics',
                'pickup_address' => [
                    'company_name' => '',
                    'address_line_1' => '',
                    'address_line_2' => '',
                    'postal_code' => '',
                    'city' => '',
                    'country' => '',
                    'accepted_transport_offer_terms' => false,
                ],
            ],
            [
                'id' => 6,
                'name' => 'Mayr GmbH & Co. KG',
                'city' => 'Gebsattel',
                'price_per_pallet_inbound' => 2.37,
                'price_per_day_storage' => 4.23,
                'price_per_pallet_outbound' => 2.99,
                'max_pallet_height_in_rack_storage' => 1093,
                'max_pallet_weight_in_rack_storage' => 441,
                'max_pallet_length_in_rack_storage' => 1200,
                'max_pallet_width_in_rack_storage' => 800,
                'max_pallet_positions' => 361,
                'transportation_requested' => false,
                'transportation_provider' => 'superlogistics',
                'pickup_address' => [
                    'company_name' => '',
                    'address_line_1' => '',
                    'address_line_2' => '',
                    'postal_code' => '',
                    'city' => '',
                    'country' => '',
                    'accepted_transport_offer_terms' => false,
                ],
            ],
        ];

        return [
            Repeater::make('warehouses')
                ->hiddenLabel()
                // ->relationship()
                ->grid(2)
                ->columnSpanFull()
                ->default($defaultWarehouses)
                ->schema([
                    Section::make(__('Transportation'))
                        ->columnSpan('full')
                        ->columns(1)
                        ->schema(function () {
                            return [
                                Toggle::make('transportation_requested')
                                    ->label(__('Transportation requested'))
                                    ->helperText(__('I need transportation for my pallets.'))
                                    ->live(debounce: 500)
                                    ->default(false),
                                Grid::make(1)
                                    ->live(debounce: 500)
                                    ->visible(function (Get $get) {
                                        return $get('transportation_requested') === true;
                                    })
                                    ->schema([
                                        Placeholder::make('transportation_info')
                                            ->key('transportation_info')
                                            ->hintIcon(Heroicon::TRANSPORTATION)
                                            ->hintAction(
                                                function () {
                                                    return
                                                        Action::make('Different pick-up address')
                                                            ->label(__('Select pick-up address'))
                                                            ->color('primary')
                                                            ->modalHeading(__('Select pick-up address'))
                                                            ->form(function (Placeholder $component, Get $get) use (&$ref) {
                                                                $filamentComponent = new FilamentComponentAddress($get);

                                                                return [
                                                                    TextInput::make('pickup_address.company_name')
                                                                        ->default(function () use ($filamentComponent) {
                                                                            return $filamentComponent->getName();
                                                                        })
                                                                        ->label(__('Company name'))
                                                                        ->required(),
                                                                    TextInput::make('pickup_address.address_line_1')
                                                                        ->default(function () use ($filamentComponent) {
                                                                            return $filamentComponent->getAddressLine1();
                                                                        })
                                                                        ->label(__('Address line 1'))
                                                                        ->required(),
                                                                    TextInput::make('pickup_address.address_line_2')
                                                                        ->default(function () use ($filamentComponent) {
                                                                            return $filamentComponent->getAddressLine2();
                                                                        })
                                                                        ->label(__('Address line 2')),
                                                                    Grid::make()
                                                                        ->schema([
                                                                            TextInput::make('pickup_address.postal_code')
                                                                                ->default(function () use ($filamentComponent) {
                                                                                    return $filamentComponent->getPostalCode();
                                                                                })
                                                                                ->validationAttribute(__('Postal code'))
                                                                                ->minLength(5)
                                                                                ->maxLength(5)
                                                                                ->label(__('Postal code'))
                                                                                ->required(),
                                                                            TextInput::make('pickup_address.city')
                                                                                ->default(function () use ($filamentComponent) {
                                                                                    return $filamentComponent->getCity();
                                                                                })
                                                                                ->label(__('City'))
                                                                                ->required(),
                                                                        ]),
                                                                    Select::make('pickup_address.country')
                                                                        ->validationAttribute(__('Country'))
                                                                        ->label(__('Country'))
                                                                        ->options([
                                                                            'DE' => 'Germany',
                                                                            'AT' => 'Austria',
                                                                            'CH' => 'Switzerland',
                                                                        ])
                                                                        ->required()
                                                                        ->default(function () use ($filamentComponent) {
                                                                            return $filamentComponent->getCountry();
                                                                        }),
                                                                    Toggle::make('pickup_address.accepted_transport_offer_terms')
                                                                        ->validationAttribute(__('Transport offer terms'))
                                                                        ->accepted()
                                                                        ->required()
                                                                        ->helperText(__('I agree to the terms and conditions.'))
                                                                        ->required()
                                                                        ->default(function () use ($filamentComponent) {
                                                                            return $filamentComponent->getAcceptedTransportOfferTerms();
                                                                        }),
                                                                ];
                                                            })
                                                            ->modalSubmitActionLabel(__('Save'))
                                                            ->action(function ($component) {
                                                                $statePath = $component->getStatePath(); // data.warehouses.*.transportation_info
                                                                dd($statePath);
                                                            });
                                                }
                                            )
                                            ->hiddenLabel()
                                            ->content(function (Get $get): string {
                                                $filamentComponent = new FilamentComponentAddress($get);

                                                if (! $filamentComponent->getName() || ! $filamentComponent->getAddressLine1() || ! $filamentComponent->getPostalCode() || ! $filamentComponent->getCity() || ! $filamentComponent->getCountry() || ! $filamentComponent->getAcceptedTransportOfferTerms()) {
                                                    return __('Please select a pick-up address.');
                                                }

                                                return __('Pick-up address: :address', [
                                                    'address' => $filamentComponent->getHumanReadableAddress(),
                                                ]);
                                            }),
                                    ]),
                            ];
                        }),
                ])
                ->deleteAction(
                    function (Action $action) {
                        return $action->requiresConfirmation();
                    },
                )
                ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                ->validationAttribute(__('Warehouses'))->rules([
                    function () {
                        return function (string $attribute, $value, Closure $fail) {
                            $min = 1;
                            if (count($value) < $min) {
                                $fail(trans_choice('validation.gte.array', $min, [
                                    'value' => $min,
                                ]));
                            }
                        };
                    },
                ]),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\CreateOrder::route('/'),
        ];
    }
}
