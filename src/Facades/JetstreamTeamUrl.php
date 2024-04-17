<?php

namespace DanPalmieri\JetstreamTeamUrl\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \DanPalmieri\JetstreamTeamUrl\JetstreamTeamUrl
 */
class JetstreamTeamUrl extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \DanPalmieri\JetstreamTeamUrl\JetstreamTeamUrl::class;
    }
}
