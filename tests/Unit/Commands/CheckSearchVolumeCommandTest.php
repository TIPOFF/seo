<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Commands;

use Illuminate\Bus\PendingBatch;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Str;
use Mockery\MockInterface;
use Tipoff\GoogleApi\DataTransferObjects\AccessToken;
use Tipoff\GoogleApi\Facades\GoogleOauth;
use Tipoff\GoogleApi\GoogleServices;
use Tipoff\Seo\Jobs\CheckKeywordSearchVolumeJob;
use Tipoff\Seo\Tests\TestCase;

class CheckSearchVolumeCommandTest extends TestCase
{
    use DatabaseTransactions;

    protected array $fakeToken;

    public function setUp(): void
    {
        parent::setUp();

        $this->fakeToken = [
            'access_token' => 'mock-access-token',
            'expires_in' => now()->addDay()->timestamp,
            'scope' => 'https://www.googleapis.com/auth/business.manage',
            'token_type' => 'Bearer',
            'created' => time(),
            'refresh_token' => 'mock-refresh-token',
        ];
    }

    /** @test */
    public function check_search_volume()
    {
        Bus::fake(CheckKeywordSearchVolumeJob::class);

        GoogleOauth::shouldReceive('accessToken')->once()->andReturn(new AccessToken($this->fakeToken));

        $this->partialMock(GoogleServices::class, function (MockInterface $mock) {
            $mock->shouldReceive('setAccessToken')
                    ->once()
                    ->withAnyArgs()
                    ->andReturnSelf();

            $mock->shouldReceive('searchConsole->setQuotaUser->searchAnalyticsQuery')
                    ->once()
                    ->withAnyArgs()
                    ->andReturn($this->getDataRows());
        });

        $this->artisan('keywords:check-search-volume test --limit=5')
            ->assertExitCode(0);

        Bus::assertBatched(function (PendingBatch $batch) {
            return $batch->allowsFailures() === true &&
                    $batch->name == 'check-keyword-search-volume-' . date('Y-m-d');
        });
    }

    private function getDataRows(): Collection
    {
        $uniqueHash = md5(Str::random(20));
        $dataRows = collect([
            $uniqueHash => [
                "country" => 'test',
                "device" => 'test',
                'clicks' => 10,
                'impressions' => 10,
                'ctr' => 0.2,
                'position' => 10,
                'searchType' => 'web',
                'dataState' => 'all',
                'aggregationType' => 'auto',
            ],
        ]);

        return $dataRows;
    }
}
