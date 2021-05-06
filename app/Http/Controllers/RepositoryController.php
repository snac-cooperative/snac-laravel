<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use Illuminate\Http\Request;

class RepositoryController extends Controller
{



    /**
     * Show the step 1 Form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function new(Request $request)
    {
        $repository = $request->session()->get('repository') ?? new Repository;
        // $repository = new Repository;
        // require('/Users/josephglass/.composer/vendor/autoload.php');
        // \Psy\Shell::debug(get_defined_vars(), $this);
        return view('repositories.create-step1', compact('repository', $repository));
    }

    /**
     * Post Request to store step1 info in session
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $validatedData = $request->validate([
            // 'name' => 'required|unique:products',
            // 'amount' => 'required|numeric',
            // 'company' => 'required',
            // 'available' => 'required',
            // 'description' => 'required',
        ]);
            require('/Users/josephglass/.composer/vendor/autoload.php');
            \Psy\Shell::debug(get_defined_vars(), $this);
        if (empty($request->session()->get('repository'))) {
            $repository = new Repository();
            $repository->fill($validatedData);
            $request->session()->put('repository', $repository);
        } else {
            $repository = $request->session()->get('repository');
            $repository->fill($validatedData);
            $request->session()->put('repository', $repository);
        }

        return redirect('/repositories/create-step2');
    }
}
