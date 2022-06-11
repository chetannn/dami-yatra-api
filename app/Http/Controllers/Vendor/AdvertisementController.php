<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class AdvertisementController extends Controller
{
    public function store(Request $request) : JsonResponse
    {
       $validated = $request->validate([
            'title' => 'required',
            'description' => ['required', 'max:200'],
            'tags.*' => ['required'],
            'ad_end_date' => ['required', 'date']
        ]);

       try {

           DB::beginTransaction();

           $advertisement = auth()->user()->vendor()
                ->first()
               ->advertisements()
               ->create(Arr::except($validated, 'tags'));

           $tags = $request->input('tags');

           $advertisement->tags()->createMany(array_map(fn($tag) => ['name' => $tag], $tags));

          DB::commit();

          return new JsonResponse([], Response::HTTP_CREATED);

       }

       catch (\Exception $exception) {

            DB::rollBack();

           return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
       }

    }

    public function destroy(Advertisement $advertisement) : JsonResponse
    {
        abort_if(auth()->user()->vendor()->first()->id != $advertisement->vendor_id, Response::HTTP_FORBIDDEN);

        $advertisement->delete();

        return new JsonResponse([]);
    }
}
