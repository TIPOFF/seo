<?php

declare(strict_types=1);

namespace Tipoff\Seo\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Authorization\Models\User;
use Tipoff\Seo\Models\Company;
use Tipoff\Seo\Tests\TestCase;

class CompanyModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        $model = Company::factory()->create();
        $this->assertNotNull($model);
    }

    /** @test */
    public function after_save_other_user_company_are_false()
    {
        $users = User::factory()->count(2)->create();

        $company = Company::factory()->create();

        foreach ($users as $user) {
            $company->users()->attach($user->id, ['creator_id' => $user->id, 'updater_id' => $user->id, 'primary_contact' => true]);
        }
        
        $option = $company->users->take(2);

        $this->assertSame(! (bool)$option[0]->pivot->primary_contact, (bool)$option[1]->pivot->primary_contact);
    }
}
