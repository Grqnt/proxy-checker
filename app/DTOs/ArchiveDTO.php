<?php

namespace App\DTOs;

namespace App\DTOs;

use BiBi\SiteSettings\DTOs\SettingDTO;
use WendellAdriel\ValidatedDTO\SimpleDTO;

class ArchiveDTO extends SimpleDTO
{
    public ?SettingDTO $maxOfferDeliveryTimeSetting;

    public ?SettingDTO $mostAffordableOffersCountSetting;

    public ?SettingDTO $fastestOffersCountSetting;

    protected function defaults(): array
    {
        return [
            'maxOfferDeliveryTimeSetting' => null,
            'mostAffordableOffersCountSetting' => null,
            'fastestOffersCountSetting' => null,
        ];
    }

    protected function casts(): array
    {
        return [];
    }
}
