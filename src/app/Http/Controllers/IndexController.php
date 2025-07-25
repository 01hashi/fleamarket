<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        $items = Item::inRandomOrder()->take(15)->get();
        $likeItems = null;

        if (Auth::check()) {
            $user = Auth::user();
            $likeItems = $user->likeItems;
        }

        return view('index', compact('items', 'likeItems'));
    }

    public function search(Request $request)
    {
        $searchText = $request->input('searchText');

        $items = Item::where('name', 'like', '%' . $searchText . '%')
            ->orWhere('description', 'like', '%' . $searchText . '%')
            ->orWhereHas('categories', function ($query) use ($searchText) {
                $query->where('name', 'like', '%' . $searchText . '%')
                    ->orWhereHas('parent', function ($parentQuery) use ($searchText) {
                        $parentQuery->where('name', 'like', '%' . $searchText . '%');
                    });
            })
            ->get();

        return view('index_search',compact('items'));
    }
}