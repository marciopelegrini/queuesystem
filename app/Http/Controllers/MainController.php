<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use App\Models\QueueTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function index()
    {
        // get list of active queues for the auth user's company
        $queues = $this->getQueueList();
        $data = [
            'subtitle' => 'Home',
            'queues' => $queues
        ];
        dd($data);
        return view('home', $data);
    }

    public function getQueueList()
    {
        return Queue::where('id_company', Auth::user()->id_company)
            ->where('status', 'active')
            ->withCount('tickets')
            ->get()->sortBy('name');
    }
}
