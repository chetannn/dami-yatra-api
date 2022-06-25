<?php

namespace Tests\Feature\Vendor;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CouponControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

   public function test_vendor_can_create_coupons()
   {
       $user = User::factory()->create();

       Vendor::factory()
           ->for($user)
           ->create();

       $this
           ->actingAs($user)
           ->postJson(route('coupons.store'), [
              'name' => $this->faker->sentence,
              'discount_rate' => 10.50,
              'limit' => 200,
              'expiration_date' => now()->addDays(5)->toDateTimeLocalString()
           ])
           ->assertCreated();
   }

   public function test_validation_fails_when_required_fields_are_missing_while_creating_coupons()
   {
       $user = User::factory()->create();

       Vendor::factory()
           ->for($user)
           ->create();

       $this
           ->actingAs($user)
           ->postJson(route('coupons.store'), [])
           ->assertUnprocessable();
   }
}
