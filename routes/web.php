<?php

use App\Http\Controllers\AgeDiscountController;
use App\Http\Controllers\BookYearController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\FamilyMemberController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\MembershipController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Guest
Route::middleware('guest')->controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLogin')->name('show.login');
    Route::post('/login', 'login')->name('login');
});

// Logged in
Route::middleware('auth')->group(function () {
    // Admin and all users start here.
    Route::get('/family', [FamilyController::class, 'index'])->name('family.index');

    // Shared routes
    Route::get('/family/{id}', [FamilyController::class, 'showFamily'])->name('family.show');
    Route::get('/family-members/{id}',
        [FamilyMemberController::class, 'show'])->name('family_member.show');
    Route::put('/password-edit', [PasswordController::class, 'update'])->name('password.update');

    // Admin Routes
    Route::middleware('isAdmin')->group(function () {
        // family
        Route::post('/family', [FamilyController::class, 'store'])->name('family.store');
        Route::put('/family/{family}', [FamilyController::class, 'update'])->name('family.update');
        Route::delete('/family/{family}', [FamilyController::class, 'destroy'])->name('family.delete');

        // family members
        Route::post('/family-members',
            [FamilyMemberController::class, 'store'])->name('family_member.store');
        Route::put('/family-members/{user}',
            [FamilyMemberController::class, 'update'])->name('family_member.update');
        Route::delete('/family-members/{id}',
            [FamilyMemberController::class, 'destroy'])->name('family_member.delete');

        // Contributions
        Route::get('/contributions', [ContributionController::class, 'index'])->name('contribution.index');
        Route::post('/contributions', [ContributionController::class, 'store'])->name('contribution.store');
        Route::get('contributions/edit/{contribution}',
            [ContributionController::class, 'edit'])->name('contribution.edit');
        Route::put('contributions/{contribution}',
            [ContributionController::class, 'update'])->name('contribution.update');
        Route::delete('contributions/{contribution}',
            [ContributionController::class, 'destroy'])->name('contribution.delete');

        // Book years
        Route::get('/book-years', [BookyearController::class, 'index'])->name('book_years.index');
        Route::post('/book-years', [BookyearController::class, 'store'])->name('book_years.store');
        Route::delete('/book-years/{bookYear}',
            [BookyearController::class, 'destroy'])->name('book_years.delete');

        // Memberships
        Route::get('/memberships', [MembershipController::class, 'index'])->name('memberships.index');
        Route::get('/memberships/{membership}',
            [MembershipController::class, 'edit'])->name('memberships.edit');
        Route::post('/memberships', [MembershipController::class, 'store'])->name('memberships.store');
        Route::put('/memberships/{membership}',
            [MembershipController::class, 'update'])->name('memberships.update');
        Route::delete('/memberships/{membership}',
            [MembershipController::class,'destroy'])->name('memberships.delete');

        // Age Discounts
        Route::get('/age-discounts', [AgeDiscountController::class, 'index'])->name('age_discounts.index');
        Route::post('/age-discounts', [AgeDiscountController::class, 'store'])->name('age_discounts.store');
        Route::get('age-discounts/edit/{ageDiscount}',
            [AgeDiscountController::class, 'edit'])->name('age_discounts.edit');
        Route::put('age-discounts/{ageDiscount}',
            [AgeDiscountController::class, 'update'])->name('age_discounts.update');
        Route::delete('/age-discounts/{ageDiscount}',
            [AgeDiscountController::class,'destroy'])->name('age_discounts.delete');
    });
});




