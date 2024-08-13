<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Models\Repository;
use Illuminate\Http\Request;

class EntityController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $repository = new Repository;
        return view('entities.entity_step_1', ['repository' => $repository]);
    }

}
