<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    public function index()
    {


        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tags', 'search']))->paginate(2)

        ]);
    }

    public function show(Listing $listing)
    {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    public function create()
    {
        return view('listings.create');
    }

    public function store(Request $request)
    {
        $formFIelds = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'



        ]);
        if ($request->hasFile('logo')) {
            $formFIelds['logo'] = $request->file('logo')->store('logos', 'public');
        }

        Listing::create($formFIelds);

        return redirect("/")->with('message', 'Job Listing added successfuly!');
    }

    public function edit(Listing $listing)
    {
        return view('listings.edit', ['listing' => $listing]);
    }

    public function update(Request $request, Listing $listing)
    {
        $formFIelds = $request->validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'



        ]);
        if ($request->hasFile('logo')) {
            $formFIelds['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formFIelds);

        return back()->with('message', 'Job Listing updated successfuly!');
    }

    public function destroy(Listing $listing)
    {
        $listing->delete();
        return redirect("/")->with('message', 'Job Listing deleted successfuly!');
    }
}
