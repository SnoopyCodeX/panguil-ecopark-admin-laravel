<?php

namespace App\Http\Controllers\Tourist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RatingsAndReviewsController extends Controller
{
    public function index()
    {
        $page = 'ratings_and_reviews';

        return view('tourist.ratings_and_reviews', compact('page'));
    }
}
