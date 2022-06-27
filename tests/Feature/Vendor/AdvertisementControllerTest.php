<?php

namespace Tests\Feature\Vendor;

use App\Models\Advertisement;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdvertisementControllerTest extends TestCase
{

    use WithFaker;
    use RefreshDatabase;

    public function test_vendor_can_create_advertisement()
    {
        $user = User::factory()->create();
        Vendor::factory()->for($user)->create();
        $coverImage = UploadedFile::fake()->image('cover.jpg', 400, 400);


        $payload = [
            'title' => $this->faker->sentence(2),
            'description' => $this->faker->sentence(5),
            'ad_end_date' => now()->format('Y-m-d'),
            'is_published' => true,
            'tags' => [
                'Pokhara',
                'Rara',
                'TravelNepal'
            ],
            'cover_image' => $coverImage,
            'duration' => '4 Nights 5 Days',
            'price' => 8500
        ];

        $this
            ->actingAs($user)
            ->postJson(route('vendor.advertisement.store'), $payload)
            ->assertCreated();

    }

    public function test_vendor_can_upload_itinerary_file_and_cover_image_while_creating_advertisement()
    {
        Storage::fake('local');

        $user = User::factory()->create();
        Vendor::factory()->for($user)->create();

        $file = UploadedFile::fake()->create('test.pdf', 2048);
        $coverImage = UploadedFile::fake()->image('cover.jpg', 400, 400);

        $payload = [
            'title' => $this->faker->sentence(2),
            'description' => $this->faker->sentence(5),
            'ad_end_date' => now()->format('Y-m-d'),
            'is_published' => true,
            'tags' => [
                'Pokhara',
                'Rara',
                'TravelNepal'
            ],
            'itinerary_file' => $file,
            'cover_image' => $coverImage,
            'duration' => '4 Nights 5 Days',
            'price' => 5000
        ];

            $this
            ->actingAs($user)
            ->post(route('vendor.advertisement.store'), $payload)
                ->assertCreated();

         $advertisement = Advertisement::first();

        Storage::disk('local')->assertExists($advertisement->itinerary_file);
        Storage::disk('local')->assertExists($advertisement->cover_image_path);

        $this->assertFileEquals($file, Storage::disk('local')->path($advertisement->itinerary_file));
        $this->assertFileEquals($coverImage, Storage::disk('local')->path($advertisement->cover_image_path));

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

    public function test_vendor_can_update_his_unpublished_advertisement()
    {
        $this->withoutExceptionHandling();

        Storage::fake('local');

        $user = User::factory()->create();
        $vendor = Vendor::factory()->for($user)->create();

       $advertisement = Advertisement::factory()
            ->for($vendor)
            ->create();

        $coverImage = UploadedFile::fake()->image('cover.jpg', 400, 400);

       $payload = [
            'title' => $this->faker->sentence,
           'description' => $this->faker->sentence(6),
           'ad_end_date' => now()->addHours(2)->format('Y-m-d'),
           'is_published' => 0,
           'tags' => [
               'Pokhara',
               'Rara',
               'TravelNepal'
           ],
           'cover_image' => $coverImage,
           'duration' => '4 Nights 5 Days',
           'price' => 5000

       ];

            $this
            ->actingAs($user)
            ->putJson(route('vendor.advertisement.update', [
                'advertisement' => $advertisement->id
            ]), $payload)
            ->assertOk();


        $this->assertDatabaseCount('advertisements', 1);
        $this->assertDatabaseHas('advertisements', Arr::except($payload, ['tags', 'cover_image']) + [
               'vendor_id' => $vendor->id,
                'id' => $advertisement->id
            ]);

    }

    public function test_vendor_can_only_update_his_unpublished_advertisement()
    {
        $user = User::factory()->create();
        $vendor = Vendor::factory()->for($user)->create();

        $advertisement = Advertisement::factory()
            ->for($vendor)
            ->create();

        $unAuthorizedUser =  User::factory()->create();
        Vendor::factory()->for($unAuthorizedUser)->create();

        $coverImage = UploadedFile::fake()->image('cover.jpg', 400, 400);

        $payload = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence(6),
            'ad_end_date' => now()->addHours(2)->format('Y-m-d'),
            'is_published' => 1,
            'tags' => [
                'Pokhara',
                'Rara',
                'TravelNepal'
            ],
            'cover_image' => $coverImage,
            'duration' => '4 Nights 5 Days',
            'price' => 5000

        ];

        $this
            ->actingAs($unAuthorizedUser)
            ->putJson(route('vendor.advertisement.update', [
                'advertisement' => $advertisement->id
            ]), $payload)
            ->assertForbidden();

    }

    public function test_vendor_can_see_all_of_his_advertisements()
    {
        $user = User::factory()->create();
        $vendor = Vendor::factory()->for($user)->create();

            Advertisement::factory()
            ->for($vendor)
            ->count(4)
            ->create();

        Advertisement::factory()
            ->for($vendor)
            ->count(4)
            ->create(['is_published' => true]);


        $unAuthorizedUser =  User::factory()->create();
        $unAuthorizedVendor = Vendor::factory()->for($unAuthorizedUser)->create();

        Advertisement::factory()
            ->for($unAuthorizedVendor)
            ->count(2)
            ->create();

           $this
            ->actingAs($user)
            ->getJson(route('vendor.advertisement.index'))
            ->assertOk()
            ->assertJsonPath('total', 8);
    }

    public function test_vendor_can_see_all_of_his_drafts_advertisements()
    {
        $user = User::factory()->create();
        $vendor = Vendor::factory()->for($user)->create();

        Advertisement::factory()
            ->for($vendor)
            ->count(4)
            ->create(['is_published' => false]);

        Advertisement::factory()
            ->for($vendor)
            ->count(4)
            ->create(['is_published' => true]);

        $this
            ->actingAs($user)
            ->getJson(route('vendor.advertisement.index', [
                'is_published' => false
            ]))
            ->assertOk()
            ->assertJsonCount(4, 'data');

    }

}
