<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookYear;

class BookYearController extends Controller
{
    public function index()
    {
        $bookYears = BookYear::where('name', '!=', '0000')->paginate(6);
        return view('bookyears.index', ['bookYears' => $bookYears]);
    }

    public function store(Request $request)
    {
        $validated  = $request->validate([
            'name' => [
                'required',
                'string',
                'regex:/^\d{4}$/',
                'unique:book_years,name'
            ],
        ]);
        BookYear::create($validated);

        return redirect()->route('book_years.index')->with('success', 'Nieuwe boekjaar is aangemaakt');
    }

    public function destroy(BookYear $bookYear)
    {
        if($bookYear->contributions()->exists()) {
            return redirect()->route('book_years.index')
                ->with('error', 'Boekjaar is gekoppeld aan een contributie en kan niet verwijderd worden.');
        }

        try {
            if($bookYear->delete()) {
                return redirect()->route('book_years.index')->with('success', 'Boekjaar is verwijderd');
            }
        } catch (\Exception $exception){
            return redirect()->route('book_years.index')->with('error', $exception->getMessage());
        }

        // Unknown error
        return redirect()->route('book_years.index')
            ->with('error', 'Er is iets misgegaan bij het verwijderen van de boekjaar.');
    }
}
