<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdvertisementRequest;
use App\Models\Advertisement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AdvertisementController extends Controller
{

    public function index() : LengthAwarePaginator
    {
       return auth()->user()
            ->vendor()
            ->first()
            ->advertisements()
            ->withCount('favoritedBy')
            ->when(request()->has('status'),
                fn(Builder $builder) => $builder->where('status', request('status')) )
           ->latest()
            ->paginate(request('per_page', 6));
    }

    public function store(AdvertisementRequest $request) : JsonResponse
    {
       try {

           DB::beginTransaction();

           $filePath = null;
           $coverImagePath = null;

           $advertisement = auth()->user()->vendor()
                ->first()
               ->advertisements()
               ->create(Arr::except($request->all(), 'tags'));

           $tags = $request->input('tags');

           if(isset($tags)) {
               $advertisement->tags()->createMany(array_map(fn($tag) => ['name' => $tag], $tags));
           }

           if($request->hasFile('itinerary_file')) {
             $filePath = Storage::putFile("advertisements/{$advertisement->id}/itinerary_file", $request->file('itinerary_file'));
           }

           if($request->hasFile('cover_image')) {
               $coverImagePath = Storage::putFile("advertisements/{$advertisement->id}/cover_photo", $request->file('cover_image'));
           }

           if(filled($filePath)) {
               $advertisement->update([
                   'itinerary_file' => $filePath
               ]);
           }

           if(filled($coverImagePath)) {
               $advertisement->update([
                   'cover_image' => $coverImagePath
               ]);
           }

           DB::commit();

          return new JsonResponse($advertisement, Response::HTTP_CREATED);

       }

       catch (\Exception $exception) {

            DB::rollBack();

            logger($exception);

           return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
       }

    }

    public function update(AdvertisementRequest $request, Advertisement $advertisement) : JsonResponse
    {
        abort_if($advertisement->vendor_id != auth()->user()->vendor()->first()->id, Response::HTTP_FORBIDDEN);

        try {

            $filePath = null;

            DB::beginTransaction();

            if($request->hasFile('itinerary_file')) {
                Storage::delete($advertisement->itinerary_file);

                $filePath = Storage::putFile('itinerary_files/' . $advertisement->id, $request->file('itinerary_file'));

            }

            $advertisement->update(Arr::except($request->validated(), 'tags') + [
                    'itinerary_file' => $filePath
                ]);

            $tags = $request->input('tags');

            if(isset($tags)) {
                $advertisement->tags()->detach();
                $advertisement->tags()->createMany(array_map(fn($tag) => ['name' => $tag], $tags));
            }

            DB::commit();

            return new JsonResponse([]);

        }

        catch (\Exception $exception) {

            DB::rollBack();

            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

    }

    public function show(Advertisement $advertisement) : JsonResponse
    {
        return new JsonResponse($advertisement->load('tags', 'vendor')->loadCount('favoritedBy'));
    }

    public function destroy(Advertisement $advertisement) : JsonResponse
    {
        abort_if(auth()->user()->vendor()->first()->id != $advertisement->vendor_id, Response::HTTP_FORBIDDEN);

        $advertisement->delete();

        return new JsonResponse([]);
    }
}
