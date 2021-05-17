<?php

namespace App\Http\Controllers\Api;

use App\Constants\User\Permission;
use App\Constants\Vacancy\Status;

use App\Events\Vacancy\Created;
use App\Events\Vacancy\Updated;
use App\Http\Controllers\Controller;

use App\Http\Requests\Vacancy\CreateRequest;
use App\Http\Requests\Vacancy\UpdateRequest;
use App\Models\Filter;
use App\Models\Vacancy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;


class VacanciesController extends Controller
{

    public function index(Request $request)
    {
       //$this->authorize('view', Vacancy::class);

        if($request->has('lang')){
            app()->setlocale($request->lang);
        }

        $vacancies = Vacancy::with('filterItems');

        $selectedFilterItems = [];

        if($request->has('filters')){

            $selectedFilterIds = array_keys($request->filters);
            $filters = Filter::with(['items'])->whereIn('id', $selectedFilterIds)->get();

            foreach ($request->filters as $id => $items) {

                $filter = $filters->find($id);

                if (!$filter) continue;

                switch ($filter->type) {
                    case "radio":
                    case "checkbox":
                        $vacancies->whereHas('filterItems', function ($q) use ($items) {
                            $q->whereIn('filter_item_id', $items);
                        });

                        foreach($items as $itemId){
                            $item = $filter->items->find($itemId);
                            if(!$item) continue;
                            $selectedFilterItems[] = [
                                'filterName' => $filter->name,
                                'itemName' => $item->name,
                                'itemId' => 'filters[' . $filter->id . ']['.$item->id.']',
                            ];
                        }
                        break;
                    case "age":
                        if (isset($items['from']) || isset($items['to'])) {
                            $vacancies->where(function ($q) use ($filter, $items) {

                                $q->where(function ($q2) use ($filter, $items) {
                                    if (isset($items['from'])) $q2->where('age_from', '>=', $items['from']);
                                    if (isset($items['to'])) $q2->where('age_to', '<=', $items['to']);
                                });

                                if(isset($items['to'])){
                                    $q->orWhere(function ($q2) use ($filter, $items) {
                                        if (isset($items['from'])) $q2->where('age_from', '>=', $items['from']);
                                        $q2->where('age_to', '<=', $items['to'] + 3);
                                        $q2->where('is_individual_coordination', 1);
                                    });
                                }
                            });


                            if (isset($items['from'])) {
                                $selectedFilterItems[] = [
                                    'filterName' => $filter->name,
                                    'itemName' => 'Від ' . $items['from'],
                                    'itemId' => 'filters[' . $filter->id . '][from]',
                                    'value' => $items['from'],
                                ];
                            }

                            if (isset($items['to'])) {
                                $selectedFilterItems[] = [
                                    'filterName' => $filter->name,
                                    'itemName' => 'До ' . $items['to'],
                                    'itemId' => 'filters[' . $filter->id . '][to]',
                                    'value' => $items['to'],
                                ];
                            }

                        }

                        break;

                    case "select":
                        if ($items) {
                            $itemId = $items;
                            $vacancies->whereHas('filterItems', function ($q) use ($itemId) {
                                $q->where('filter_item_id', $itemId);
                            });

                            $item = $filter->items->find($itemId);
                            if($item){
                                $selectedFilterItems[] = [
                                    'filterName' => $filter->name,
                                    'itemName' => $item->name,
                                    'itemId' => 'filters[' . $filter->id . ']',
                                    'value' => $item->id,
                                ];
                            }
                        }
                        break;
                }
            }
        }

        if($request->has('status')){
            if($request->status == Status::Visible){
                $vacancies->visible();
            } else if ($request->status == Status::HiddenClosed){
                $vacancies->hiddenClosed();
            }
        }

        if($request->has('order')){

            Cache::forever('vacancy_order_for_'.auth()->id(), $request->order);
            switch ($request->order){
                case 'date_desc':
                    $vacancies->orderBy('updated_at','desc');
                    break;
                case 'priority':
                default:
                    $vacancies->orderBy('is_urgently','desc')->orderBy('updated_at','desc');
                    break;
            }
        }

        $vacancies = $vacancies->get();

        return new JsonResponse([
            'vacancies' => $vacancies,
            'selected_filters' =>  $selectedFilterItems
        ], 200);
    }

    public function getStatuses(Request $request)
    {
        //$this->authorize('view', Vacancy::class);

        $statuses = config('constants.vacancy_statuses');

        return new JsonResponse([
            'statuses' => $statuses
        ], 200);
    }

    public function store(CreateRequest $request)
    {

        $this->authorize('control',  Vacancy::class);
        $user = Auth::user();

        $validated = $request->validated();

        unset($validated['filter_items']);

        $vacancy = new Vacancy($validated);
        $vacancy->user()->associate($user);
        $vacancy->save();

        if($vacancy->status == Status::Visible){
            event(new Created($vacancy));
        }

        if($request->has('filter_items')){
            $vacancy->filterItems()->sync(array_filter($request->filter_items));
        }

        $vacancy->load('filterItems');

        return new JsonResponse([
            'vacancy' => $vacancy
        ], 200);
    }

    public function update(UpdateRequest $request, Vacancy $vacancy)
    {

        $this->authorize('control', Vacancy::class);

        $validated = $request->validated();
        $validated['is_urgently'] = ($request->has('is_urgently')) ? 1:0;
        $validated['is_individual_coordination'] = ($request->has('is_individual_coordination')) ? 1:0;

        unset($validated['filter_items']);

        $vacancy->update($validated);

        if($request->has('filter_items')){
            $vacancy->filterItems()->sync(array_filter($request->filter_items));
        }

        if ($vacancy->status == Status::Visible && $vacancy->wasChanged(['content', 'changes'])){
            if(mb_strlen($vacancy->content)){
                event(new Updated($vacancy));
            }
        }

        $vacancy->load('filterItems');

        return new JsonResponse([
            'vacancy' => $vacancy
        ], 200);
    }

    public function destroy(Vacancy $vacancy)
    {
        $this->authorize('control', Vacancy::class);

        $vacancy->filterItems()->detach();
        $vacancy->delete();
        return new JsonResponse([], 200);
    }

    public function show(Vacancy $vacancy)
    {
        $this->authorize('view', Vacancy::class);

        return response()->json([
            'vacancy' => $vacancy
        ]);
    }

}
