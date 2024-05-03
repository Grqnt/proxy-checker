<?php

namespace App\DTOs;

use WendellAdriel\ValidatedDTO\SimpleDTO;

class ProxyDTO extends SimpleDTO
{

    public string $id;
    public string $ip;

    public int $port;

    public string $geo;

    public int $timeout;

    public string $realIp;

    public string $archiveId;


    protected function defaults(): array
    {
        return [
            'geo' => null,
        ];
    }

    public function exportToArrayModel(): array
    {
        $mapping = $this->modelMap();
        $result = [];
        foreach (get_class_vars($this::class) as $key => $value) {
            if (array_key_exists($key, $mapping)) {
                $result[$mapping[$key]] = $this->$key;
            }
        }

        return $result;
    }


    protected function modelMap(): array
    {
        return [
            'id' => 'id',
            'ip' => 'ip',
            'port' => 'port',
            'geo' => 'geo',
            'timeout' => 'timeout',
            'realIp' => 'real_ip',
            'archiveId' => 'archive_id',
        ];
    }


    protected function casts(): array
    {
        return [];
    }
}
