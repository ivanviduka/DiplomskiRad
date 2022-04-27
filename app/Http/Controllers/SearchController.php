<?php

namespace App\Http\Controllers;

use App\Actions\DatabaseAction;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(DatabaseAction $action)
    {
        $options = $action->getSearchOptions();
        return view('dashboard.search', [
            'subjects' => $options[0],
            'years' => $options[1],
            'majors' => $options[2],
        ]);

    }

    public function search(Request $request, DatabaseAction $action)
    {
        $query = $action->buildSearchQuery($request);

        $searchResults = $query->paginate(8)->appends(request()->query());

        return view('dashboard.search-results', ['files' => $searchResults]);

    }
}
