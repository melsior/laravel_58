<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DiggingDeeperController extends Controller
{
    /**
     * Базовая информация:
     *
     * Справочная информация:
     *
     * Вариант коллекции для моделей eloquent:
     *
     * Билдер запросов - то с чем можно перепутать коллекции:
     *
     */
    public function collections()
    {
        $result = [];

        /** @var \Illuminate\Database\Eloquent\Collection $eloquentCollection */
        $eloquentCollection = BlogPost::withTrashed()->get();

        //dd(__METHOD__, $eloquentCollection, $eloquentCollection->toArray());

        $collection = collect($eloquentCollection->toArray());
        /*$collection = collect();
        dd($collection);*/

//        dd(
//            get_class($eloquentCollection),
//            get_class($collection),
//            $collection->isNotEmpty()
//        );

     /*   $result['first'] = $collection->first();
        $result['last'] = $collection->last();

        $result['where']['data'] = $collection
            ->where('category_id', 10)
            ->values()
            ->keyBy('id');

        $result['where']['count'] = $result['where']['data']->count();
        $result['where']['isEmpty'] = $result['where']['data']->isEmpty();
        $result['where']['isNotEmpty'] = $result['where']['data']->isNotEmpty();

        $result['where_first'] = $collection
            ->firstWhere('created_at', '>', '2019-01-17 01:35:11');

        $result['map']['all'] = $collection->map(function (array $item) {
            $newItem = new \stdClass();
            $newItem->item_id = $item['id'];
            $newItem->item_name = $item['title'];
            $newItem->exists = is_null($item['deleted_at']);

            return $newItem;
        });

        $result['map']['not_exists'] = $result['map']['all']
            ->where('exists', '-', false)
            ->values()
            ->keyBy('item_id');*/


//        dd($result);

        $collection->transform(function ($item) {
            $newItem = new \stdClass();
            $newItem->item_id = $item['id'];
            $newItem->item_name = $item['title'];
            $newItem->exists = is_null($item['deleted_at']);
            $newItem->created_at = Carbon::parse($item['created_at']);

            return $newItem;
        });
//        dd($collection);
//        $newItem = new \stdClass();
//        $newItem->id = 9999;
//
//        $newItem2 = new \stdClass();
//        $newItem2->id = 8888;

//        dd($newItem, $newItem2);
//        $collection->prepend($newItem);
//        $collection->push($newItem2);
//        dd($newItem, $newItem2, $collection);

//        $newItemFirst = $collection->prepend($newItem)->first();
//        $newItemLast = $collection->push($newItem2)->last();
//        $pulledItem = $collection->pull(1);
//        dd(compact('collection', 'newItemFirst', 'newItemLast', 'pulledItem'));

//        $filtered = $collection->filter(function ($item) {
//            $byDay = $item->created_at->isFriday();
//            $byData = $item->created_at->day == 7;
//
//            $result = $byDay && $byData;
//
//            return $result;
//        });
//
//        dd(compact('filtered'));

        $sortedSimpleCollection = collect([5, 3, 1, 2, 4])->sort();
        $sortedAscCollection = $collection->sortBy('created_at');
        $sortedDescCollection = $collection->sortByDesc('item_id');
        dd(compact('sortedSimpleCollection', 'sortedAscCollection', 'sortedDescCollection'));
    }
}
