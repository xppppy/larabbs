<?php

namespace App\Observers;

use App\Models\Link;
use Cache;

class LinkObserver
{
    // 在保存时清空 cache_key 对应的缓存，否则更改时没法及时更改
    public function saved(Link $link)
    {
        Cache::forget($link->cache_key);
    }
}