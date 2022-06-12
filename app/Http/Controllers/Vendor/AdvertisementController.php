<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class AdvertisementController extends Controller
{

    public function index() : LengthAwarePaginator
    {
        return auth()->user()
            ->vendor()
            ->first()
            ->advertisements()
            ->paginate(request('per_page', 10));
    }

    public function store(Request $request) : JsonResponse
    {
       $validated = $request->validate([
            'title' => 'required',
            'description' => ['required', 'max:200'],
            'tags' => 'required',
            'tags.*' => ['required'],
            'is_published' => ['integer', 'between:0,1'],
            'ad_end_date' => ['required_if:is_published,1', 'date']
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

    public function update(Advertisement $advertisement, Request $request) : JsonResponse
    {
        abort_if($advertisement->vendor_id != auth()->user()->vendor()->first()->id, Response::HTTP_FORBIDDEN);

        $validated = $request->validate([
            'title' => 'required',
            'description' => ['required', 'max:200'],
            'tags' => 'required',
            'tags.*' => ['required'],
            'is_published' => ['integer', 'between:0,1'],
            'ad_end_date' => ['required_if:is_published,1', 'date']
        ]);

        try {

            DB::beginTransaction();

            $advertisement->update(Arr::except($validated, 'tags'));

            $tags = $request->input('tags');

            $advertisement->tags()->createMany(array_map(fn($tag) => ['name' => $tag], $tags));

            DB::commit();

            return new JsonResponse([]);

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
