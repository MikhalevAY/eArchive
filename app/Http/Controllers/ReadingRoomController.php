<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\View\View;

class ReadingRoomController extends Controller
{
    public function index(): View
    {
        return view('pages.reading-room')->with([
            'documents' => [],
            'tHeads' => Document::$tHeads,
            'sortBy' => ['sort' => 'id', 'order' => 'desc']
        ]);
    }
}
