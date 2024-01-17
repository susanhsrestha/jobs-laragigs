<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    // Get and show all listings
    public function index(Request $request)
    {
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)
        ]);
    }

    // Get and show single listing 
    public function show($id)
    {
        $listing = Listing::find($id);
        if ($listing) {
            return view('listings.show', [
                'listing' => Listing::find($id)
            ]);
        } else {
            abort(404);
        }
    }

    // Show create form
    public function create()
    {
        return view('listings.create');
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields['user_id'] = auth()->user()->id;

        Listing::create($formFields);
        return redirect('/')->with('message', 'Listing created successfully!!');
    }

    // Show Edit Form
    public function edit(Listing $listing) {
        return view('listings.edit', ['listing' => $listing]);
    }

    public function update(Request $request, Listing $listing)
    {
        // Make sure logged in user is owner
        if($listing->user_id != auth()->user()->id) {
            abort(403, 'Unauthorized Action');
        }
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);
        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }
        Listing::whereId($listing->id)->update($formFields);
        return back()->with('message', 'Listing updated successfully!!');
    }

    // Delete Listing
    public function destroy(Listing $listing) {
        if($listing->user_id != auth()->user()->id) {
            abort(403, 'Unauthorized Action');
        }
        $listing->delete();
        return redirect('/')->with('message', 'Listing deleted successfully!!');
    }

    // Manage Listing
    public function manage(Request $request) {
        return view('listings.manage', [
            'listings' => auth()->user()->listings()->get()
        ]);
    }
}
