<?php

namespace App\Http\Controllers;

use App\Model\Banner;
use App\Model\Event;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\View;

class AdminBaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $itemsPerPage;

    protected $searchAvailable;

    public function __construct(){
        $this->itemsPerPage = 20;

        $events = Event::all()->where('approved', '=', 0);

        View::share([
            'eventsDissaproved' => $events->count(),
            'searchAvailable' => $this->searchAvailable
        ]);

    }

}
