<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Helpers;

use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Seo\Tests\TestCase;

class ParseUrlTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
    */
    public function parse_url_validate_https_is_true()
    {
        $url = 'https://www.example.com';
        $urlPieces = parseUrl($url);

        $this->assertTrue($urlPieces['https']);
    }

    /**
     * @test
    */
    public function parse_url_validate_https_is_false()
    {
        $url = 'http://www.example.com';
        $urlPieces = parseUrl($url);

        $this->assertFalse($urlPieces['https']);
    }

    /**
     * @test
     * @dataProvider data_provider_for_parse_url_validate_all_parts_where_host_length_is_valid
    */
    public function parse_url_validate_all_parts_where_host_length_is_valid(string $url, string $subdomain, string $name, string $tld)
    {
        $urlPieces = parseUrl($url);

        $this->assertEquals($subdomain, $urlPieces['subdomain']);
        $this->assertEquals($name, $urlPieces['name']);
        $this->assertEquals($tld, $urlPieces['tld']);
    }

    public function data_provider_for_parse_url_validate_all_parts_where_host_length_is_valid()
    {
        return [
            'host-2-part' => ['https://example.com', '', 'example', 'com'],
            'host-3-part' => ['https://www.example.com', 'www', 'example', 'com'],
        ];
    }

    /**
     * @test
     * @dataProvider data_provider_for_parse_url_throws_error_where_host_length_is_invalid
    */
    public function parse_url_throws_error_where_host_length_is_invalid(string $url, Exception $exception, string $mesesage)
    {
        $urlPieces = parseUrl($url);
        
        $this->expectException($exception);
        $this->expectExceptionMessage($message);
    }

    public function data_provider_for_parse_url_throws_error_where_host_length_is_invalid()
    {
        return [
            'host-1-part' => ['https://example', Exception::class, 'Hostname only 1 part.  e.g. (3 parts) www.example.com'],
            'host-4-part' => ['https://www.unexpected.example.com', Exception::class, 'Hostname more than 3 parts.  e.g. (4 parts) www.another.example.com'],
            'host-5-part' => ['https://www.another.unexpected.example.com', Exception::class, 'Hostname more than 3 parts.  e.g. (4 parts) www.another.example.com'],
        ];
    }
}
