<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Delivery;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use DB;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $people = Person::select('people.id', 'people.folio','people.name', 'people.paternal', 'people.maternal','people.municipality','people.amount','people.check_id', 'delivery_id', 'deliveries.name as delivery')
        ->join('deliveries', 'deliveries.id', '=', 'people.delivery_id')
        ->paginate(10);

        $deliveries = Delivery::all();

        return Inertia::render('People/Index', ['people' => $people, 'deliveries' => $deliveries]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'folio' => 'required|max:15',
            'name' => 'required|max:150',
            'paternal' => 'required|max:80',
            'maternal' => 'required|max:80',
            'delivery_id' => 'required|numeric',
            'municipality' => 'required|max:15',
            'amount' => 'required|numeric',
            'check_id' => 'required|numeric',
        ]);
        $person = new Person($request->input() + ['user_id' => auth()->user()->id]);
        $person->save();
        return redirect('people');
    }

    /**
     * Display the specified resource.
     */
    public function show(Person $person)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Person $person)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Person $person)
    {
        $request->validate([
            'folio' => 'required|max:15',
            'name' => 'required|max:150',
            'paternal' => 'required|max:80',
            'maternal' => 'required|max:80',
            'delivery_id' => 'required|numeric',
            'municipality' => 'required|max:15',
            'amount' => 'required|numeric',
            'check_id' => 'required|numeric',
        ]);
        $person->update($request->input());

        return redirect('people');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Person $person)
    {
        $person->delete();
        return redirect('people');
    }
}
