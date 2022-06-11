<?php

namespace Tests\Feature\Vendor;

use App\Models\Advertisement;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdvertisementControllerTest extends TestCase
{

    use WithFaker;
    use RefreshDatabase;

    public function test_vendor_can_create_advertisement()
    {

        $user = User::factory()->create();

        Vendor::factory()->for($user)->create();

        $payload = [
            'title' => $this->faker->sentence(2),
            'description' => $this->faker->sentence(5),
            'ad_end_date' => now()->format('Y-m-d'),
            'is_published' => false,
            'tags' => [
                'Pokhara',
                'Rara',
                'TravelNepal'
            ]
        ];

        $this
            ->actingAs($user)
            ->postJson(route('vendor.advertisement.store'), $payload)
            ->assertCreated();

    }

    public function test_validation_fails_if_required_fields_are_not_provided_for_advertisement()
    {
        $user = User::factory()->create();

        Vendor::factory()->for($user)->create();

        $this
            ->actingAs($user)
            ->postJson(route('vendor.advertisement.store'), [])
            ->assertUnprocessable();
    }

    public function test_vendor_can_delete_advertisement_that_belongs_to_him()
    {

        $user = User::factory()->create();
        $vendor = Vendor::factory()->for($user)->create();

       $advertisement = Advertisement::factory()
            ->for($vendor)
            ->create();

        $this
            ->actingAs($user)
            ->deleteJson(route('vendor.advertisement.destroy', [
                'advertisement' => $advertisement
            ]))
            ->assertOk();
    }

    public function test_vendor_cannot_delete_advertisement_that_does_not_belong_to_him()
    {
        $user = User::factory()->create();
        $vendor = Vendor::factory()->for($user)->create();

        $unAuthorizedUser =  User::factory()->create();
        Vendor::factory()->for($unAuthorizedUser)->create();

        $advertisement = Advertisement::factory()
            ->for($vendor)
            ->create();

        $this
            ->actingAs($unAuthorizedUser)
            ->deleteJson(route('vendor.advertisement.destroy', [
                'advertisement' => $advertisement
            ]))
            ->assertForbidden();
    }
}
