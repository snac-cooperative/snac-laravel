<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Repository;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $repository = new Repository;
        return view('resources.resource', ['repository' => $repository]);
    }

}
