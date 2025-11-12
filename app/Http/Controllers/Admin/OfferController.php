<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Course;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offers = Offer::latest()->paginate(12);
        
        // Calculate analytics
        $totalOffers = Offer::count();
        $activeOffers = Offer::active()->count();
        $validOffers = Offer::active()->valid()->count();
        $totalUsage = Offer::sum('used_count');
        
        return view('admin.offers.index', compact('offers', 'totalOffers', 'activeOffers', 'validOffers', 'totalUsage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::select('id', 'title')->get();
        return view('admin.offers.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'code' => ['nullable', 'string', 'max:50', 'unique:offers,code'],
            'type' => ['required', 'in:percentage,fixed_amount'],
            'value' => ['required', 'numeric', 'min:0'],
            'minimum_amount' => ['nullable', 'numeric', 'min:0'],
            'usage_limit' => ['nullable', 'integer', 'min:1'],
            'valid_from' => ['required', 'date'],
            'valid_until' => ['required', 'date', 'after:valid_from'],
            'is_active' => ['boolean'],
            'applicable_courses' => ['nullable', 'array'],
            'applicable_courses.*' => ['exists:courses,id'],
        ]);

        // Additional validation for percentage type
        if ($request->type === 'percentage' && $request->value > 100) {
            return back()->withErrors(['value' => 'Percentage discount cannot exceed 100%.']);
        }

        $offerData = $request->all();
        $offerData['is_active'] = $request->has('is_active') ? true : false;
        
        // Convert dates to proper format
        $offerData['valid_from'] = Carbon::parse($request->valid_from);
        $offerData['valid_until'] = Carbon::parse($request->valid_until);
        
        // Handle course selection
        if ($request->course_selection === 'all' || empty($request->applicable_courses)) {
            $offerData['applicable_courses'] = null;
        } else {
            $offerData['applicable_courses'] = $request->applicable_courses;
        }

        Offer::create($offerData);

        return redirect()->route('admin.offers.index')
            ->with('success', 'Offer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Offer $offer)
    {
        $offer->load('applicableCourses');
        
        // Get usage statistics
        $usagePercentage = $offer->usage_limit ? ($offer->used_count / $offer->usage_limit) * 100 : 0;
        
        return view('admin.offers.show', compact('offer', 'usagePercentage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Offer $offer)
    {
        $courses = Course::select('id', 'title')->get();
        return view('admin.offers.edit', compact('offer', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Offer $offer)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'code' => ['required', 'string', 'max:50', 'unique:offers,code,' . $offer->id],
            'type' => ['required', 'in:percentage,fixed_amount'],
            'value' => ['required', 'numeric', 'min:0'],
            'minimum_amount' => ['nullable', 'numeric', 'min:0'],
            'usage_limit' => ['nullable', 'integer', 'min:1'],
            'valid_from' => ['required', 'date'],
            'valid_until' => ['required', 'date', 'after:valid_from'],
            'is_active' => ['boolean'],
            'applicable_courses' => ['nullable', 'array'],
            'applicable_courses.*' => ['exists:courses,id'],
        ]);

        $offerData = $request->all();
        
        // Convert dates to proper format
        $offerData['valid_from'] = Carbon::parse($request->valid_from);
        $offerData['valid_until'] = Carbon::parse($request->valid_until);
        
        // Handle course selection
        if ($request->course_selection === 'all' || empty($request->applicable_courses)) {
            $offerData['applicable_courses'] = null;
        } else {
            $offerData['applicable_courses'] = $request->applicable_courses;
        }

        $offer->update($offerData);

        return redirect()->route('admin.offers.index')
            ->with('success', 'Offer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Offer $offer)
    {
        $offer->delete();

        return redirect()->route('admin.offers.index')
            ->with('success', 'Offer deleted successfully.');
    }
}
