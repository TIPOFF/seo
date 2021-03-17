<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Helpers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Seo\Tests\TestCase;

class GetFaviconUrlTest extends TestCase
{
    use DatabaseTransactions;

    /** 
     * @test
     * @dataProvider data_provider_for_validate_get_favicon_url
    */
    public function validate_get_favicon_url(string $domain, int $size, string $result)
    {
        $url = getFaviconUrl($domain, $size);

        $this->assertEquals($url, $result);
    }

    public function data_provider_for_validate_get_favicon_url()
    {
        return [
            'subdomain-no-64' => ['example.com', 64, 'https://s2.googleusercontent.com/s2/favicons?domain=example.com&sz=64'],
            'subdomain-yes-64' => ['www.example.com', 64, 'https://s2.googleusercontent.com/s2/favicons?domain=www.example.com&sz=64'],
            'subdomain-no-128' => ['example.net', 128, 'https://s2.googleusercontent.com/s2/favicons?domain=example.net&sz=128'],
            'subdomain-yes-128' => ['www.example.net', 128, 'https://s2.googleusercontent.com/s2/favicons?domain=www.example.net&sz=128'],
        ];
    }

    /** 
     * @test
     * @dataProvider data_provider_for_validate_get_favicon_url_without_size
    */
    public function validate_get_favicon_url_without_size(string $domain, string $result)
    {
        $url = getFaviconUrl($domain);

        $this->assertEquals($url, $result);
    }

    public function data_provider_for_validate_get_favicon_url_without_size()
    {
        return [
            'subdomain-no' => ['example.com', 'https://s2.googleusercontent.com/s2/favicons?domain=example.com&sz=32'],
            'subdomain-yes' => ['www.example.com', 'https://s2.googleusercontent.com/s2/favicons?domain=www.example.com&sz=32'],
        ];
    }
}