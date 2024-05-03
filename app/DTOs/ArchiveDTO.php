<?php

namespace App\DTOs;

namespace App\DTOs;

use Carbon\Carbon;
use WendellAdriel\ValidatedDTO\SimpleDTO;

class ArchiveDTO extends SimpleDTO
{

    public string $id;
    public Carbon $finishAt;

    protected function defaults(): array
    {
        return [];
    }

    protected function modelMap(): array
    {
        return [
            'id' => 'id',
            'finishAt' => 'finish_at',
        ];
    }

    protected function casts(): array
    {
        return [];
    }
}
