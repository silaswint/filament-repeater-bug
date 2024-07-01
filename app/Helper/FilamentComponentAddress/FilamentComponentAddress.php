<?php

namespace App\Helper\FilamentComponentAddress;

use Filament\Forms\Get;

class FilamentComponentAddress
{
    private ?string $name;

    private ?string $addressLine1;

    private ?string $addressLine2;

    private ?string $postalCode;

    private ?string $city;

    private ?string $country;

    private bool $acceptedTransportOfferTerms = false;

    public function __construct(
        private readonly Get $get,
    ) {
        $this->name = $get('pickup_address.company_name') ? trim($get('pickup_address.company_name')) : null;
        $this->addressLine1 = $get('pickup_address.address_line_1') ? trim($get('pickup_address.address_line_1')) : null;
        $this->addressLine2 = $get('pickup_address.address_line_2') ? trim($get('pickup_address.address_line_2')) : null;
        $this->postalCode = $get('pickup_address.postal_code') ? trim($get('pickup_address.postal_code')) : null;
        $this->city = $get('pickup_address.city') ? trim($get('pickup_address.city')) : null;
        $this->country = $get('pickup_address.country') ? trim($get('pickup_address.country')) : null;
        $this->acceptedTransportOfferTerms = $get('pickup_address.accepted_transport_offer_terms') ?? false;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getAddressLine1(): ?string
    {
        return $this->addressLine1;
    }

    public function getAddressLine2(): ?string
    {
        return $this->addressLine2;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function getAcceptedTransportOfferTerms(): bool
    {
        return $this->acceptedTransportOfferTerms;
    }

    public function getHumanReadableAddress(): string
    {
        return implode(', ', array_filter([
            $this->name,
            $this->addressLine1,
            $this->addressLine2,
            $this->postalCode.' '.$this->city,
            $this->country,
        ]));
    }
}
