<?php

declare(strict_types=1);

namespace Tipoff\Seo\Models;

use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;

class Domain extends BaseModel
{
    use HasPackageFactory;
    use HasCreator;
    use HasUpdater;

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function parseUrl(string $url)
    {
        $https = true;
        $subdomain = '';
        $name = '';
        $tld = '';

        $pieces = parse_url($url);

        // host e.g. 'www.example.com'
        $host = $pieces['host'];
        $hostPieces = explode('.', $host);

        // length 4 will not work, e.g. www.some.example.com
        if (count($hostPieces) === 1) {
            // error
        }
        else if (count($hostPieces) === 2) {
            // $subdomain is an empty string
            $name = $hostPieces[0];
            $tld = $hostPieces[1];
        } else {
            $subdomain = $hostPieces[0];
            $name = $hostPieces[1];
            $tld = $hostPieces[2];
        }

        if ($pieces['scheme'] !== 'https') $https = false;

        // use $https, $subdomain, $name, $tld
    }
}
