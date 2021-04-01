<?php

declare(strict_types=1);

namespace Tipoff\Seo\Models;

use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;

class Webpage extends BaseModel
{
    use HasPackageFactory;
    use HasCreator;
    use HasUpdater;

    public function results()
    {
        return $this->morphMany(app('result'), 'resultable');
    }

    public function domain()
    {
        return $this->belongsTo(app('domain'));
    }

    public static function getDomain(string $url): ?string
    {
        $parsedUrl = parse_url($url);
        $host = explode('.', $parsedUrl['host']);

        return $host[count($host) - 2];
    }

    public static function getSubDomains(string $url): ?string
    {
        $parsedUrl = parse_url($url);
        $host = explode('.', $parsedUrl['host']);
        $subdomains = array_slice($host, 0, count($host) - 2);

        return implode(".", $subdomains);
    }

    public static function getPath(string $url): ?string
    {
        $path = parse_url($url, PHP_URL_PATH);

        return $path;
    }
}
