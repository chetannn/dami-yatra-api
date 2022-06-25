<?php

namespace Tests\Feature\Customer;

use App\Models\Advertisement;
use App\Models\Customer;
use App\Models\SavedAdvertisement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdvertisementControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

  public function test_customer_can_add_a_advertisement_to_their_favorite_list()
  {
          $user = User::factory()->create();
          Customer::factory()->for($user)->create();
          $advertisement =  Advertisement::factory()->create();

          $this
              ->actingAs($user)
              ->postJson(route('saved_advertisements.toggle'), [
                  'advertisement_id' => $advertisement->id
              ])
              ->assertOk();

          $this->assertDatabaseCount('saved_advertisements', 1);
  }

  public function test_customer_can_remove_a_advertisement_from_their_favorite_list()
  {
      $user = User::factory()->create();
      $customer = Customer::factory()->for($user)->create();
      $advertisement =  Advertisement::factory()->create();

      SavedAdvertisement::create([
          'advertisement_id' => $advertisement->id,
          'customer_id' => $customer->id,
      ]);

    $savedAdvertisement = SavedAdvertisement::create([
          'advertisement_id' => Advertisement::factory()->create()->id,
          'customer_id' => $customer->id,
      ]);

      $this
          ->actingAs($user)
          ->postJson(route('saved_advertisements.toggle'), [
              'advertisement_id' => $advertisement->id
          ])
          ->assertOk();

      $this->assertDatabaseCount('saved_advertisements', 1);
      $this->assertDatabaseHas('saved_advertisements', [
          'id' => $savedAdvertisement->id,
          'customer_id' => $customer->id,
      ]);
  }

}
