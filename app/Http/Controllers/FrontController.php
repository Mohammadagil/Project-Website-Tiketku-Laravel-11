<?php

namespace App\Http\Controllers;

use App\Services\FrontService;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\Seller;

class FrontController extends Controller
{
    protected $frontService;

    public function __construct(FrontService $frontService)
    {
        $this->frontService = $frontService;
    }
    //konsep service repository pattern
    public function index()
    {
        $data = $this->frontService->getFrontPageData();
        // dd($data);
        return view('front.index', $data);
    }

    public function details(Ticket $ticket){
        // dd($ticket);
        return view('front.details', compact('ticket'));
    }

    public function category(Category $category){
        // dd($category);
        return view('front.category', compact('category'));
    }
    public function explore(Seller $seller_city){
        // dd($seller_city);
        return view('front.seller_city', compact('seller_city'));
    }

    //konsep MVC
    // public function index(){
    //     $categories = Category::latest()->get();
    //     $popular_tickets = Ticket::where('is_popular', true)->take(4)->get();
    //     $new_tickets = Ticket::latest()->get();
    //     return view('front.index', compact('categories', 'popular_tickets', 'new_tickets'));
    // }
}
