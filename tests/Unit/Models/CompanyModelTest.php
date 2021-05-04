<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Addresses\Models\Address;
use Tipoff\Authorization\Models\User;
use Tipoff\Seo\Models\Company;
use Tipoff\Seo\Models\Domain;
use Tipoff\Seo\Models\Place;
use Tipoff\Seo\Tests\TestCase;

class CompanyModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @var Company */
    protected $company;

    public function setUp(): void
    {
        parent::setUp();

        $this->company = Company::factory()->create();
    }

    /** @test */
    public function create()
    {
        $this->assertNotNull($this->company);
    }

    /** @test */
    public function after_save_other_user_company_are_false()
    {
        $users = User::factory()->count(2)->create();

        foreach ($users as $user) {
            $this->company->users()->attach($user->id, ['creator_id' => $user->id, 'updater_id' => $user->id, 'primary_contact' => true]);
        }
        
        $option = $this->company->users->take(2);

        $this->assertSame(! (bool)$option[0]->pivot->primary_contact, (bool)$option[1]->pivot->primary_contact);
    }

    /** @test */
    public function get_domains()
    {
        $domains = Domain::factory()->count(5)->make();
        $this->company->domains()->saveMany($domains);

        $this->assertInstanceOf(HasMany::class, $this->company->domains());
        $this->assertEquals('company_id', $this->company->domains()->getForeignKeyName());
        $this->assertEquals('companies.id', $this->company->domains()->getQualifiedParentKeyName());
        $this->assertCount($domains->count(), $this->company->domains()->get());
    }

    /** @test */
    public function get_places()
    {
        $places = Place::factory()->count(5)->make();
        $this->company->places()->saveMany($places);

        $this->assertInstanceOf(HasMany::class, $this->company->places());
        $this->assertEquals('company_id', $this->company->places()->getForeignKeyName());
        $this->assertEquals('companies.id', $this->company->places()->getQualifiedParentKeyName());
        $this->assertCount($places->count(), $this->company->places()->get());
    }

    /** @test */
    public function get_domestic_address()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->company->domestic_address());
        $this->assertEquals('domestic_address_id', $this->company->domestic_address()->getForeignKeyName());
        $this->assertEquals('companies.id', $this->company->domestic_address()->getQualifiedParentKeyName());
    }

    /** @test */
    public function get_address()
    {
        $address = Address::factory()->make();
        $this->company->address()->save($address);

        $this->assertInstanceOf(MorphOne::class, $this->company->address());
        $this->assertEquals('addressable_id', $this->company->address()->getForeignKeyName());
        $this->assertEquals('addressable_type', $this->company->address()->getMorphType());
        $this->assertEquals('companies.id', $this->company->address()->getQualifiedParentKeyName());
    }
}
