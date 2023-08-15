<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd("at the controller");
        $deliveries = Delivery::all();

        return Inertia::render('Deliveries/Index', ['deliveries' => $deliveries]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Deliveries/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:30',
            'observation' => 'required|max:100'
        ]);
        // dump(auth()->user()->id);
        // dd($request);
        $delivery = new Delivery($request->input() + ['user_id' => auth()->user()->id]);

        $delivery->save();
        return redirect('deliveries');
    }

    /**
     * Display the specified resource.
     */
    public function show(Delivery $delivery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Delivery $delivery)
    {
        //dd("ok");
        return Inertia::render('Deliveries/Edit', ['delivery' => $delivery]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Delivery $delivery)
    {
        $request->session()->flash('flash.banner', 'Delivery updated!');
        $request->session()->flash('flash.bannerStyle', 'success');

        $request->validate([
            'name' => 'required|max:30',
            'observation' => 'required|max:100'
        ]);
        $delivery->update($request->all());
        return redirect('deliveries');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Delivery $delivery)
    {
        $delivery->delete();
        return redirect('deliveries');
    }
}
