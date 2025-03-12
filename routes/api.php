<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Site\SiteController;
use App\Http\Controllers\Api\V1\Keyword\KeywordController;
use App\Http\Controllers\Api\V1\SiteDetail\SiteDetailController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {

    // Keywords Routes
    Route::prefix('keywords')->middleware('permission:manage-keywords')->group(function () {
        Route::post  ('import', [KeywordController::class, 'importKeyword']);
        Route::get   ('get-all', [KeywordController::class, 'getAllKeywords']);

        // Competitors
        Route::prefix('competitors')->group(function () {
            Route::get  ('search-volume-sites', [KeywordController::class, 'competitorsSearchVolumeRankingWithAllSites']);
            Route::get  ('analyze', [KeywordController::class, 'analyzeKeywordsCompetitor']);
        });
    });

    // Sites Routes
    Route::prefix('sites')->middleware('permission:manage-sites')->group(function () {
        Route::get   ('get-all', [SiteController::class, 'getAllSites']);
        Route::get   ('get-title', [SiteController::class, 'getTitleForUrlSite']);
        Route::post  ('import', [SiteController::class, 'importSiteUrl']);
    });

    // Site Details Routes
    Route::prefix('site-details')
        ->middleware('permission:manage-site-details')
        ->group(function () {

            // Keyword Progress & Rankings
            Route::post('progress', [SiteDetailController::class, 'keywordProgress']);
            Route::post('top3', [SiteDetailController::class, 'siteKeywordTop3']);
            Route::post('top10', [SiteDetailController::class, 'siteKeywordTop10']);
            Route::post('average-position', [SiteDetailController::class, 'averagePosition']);

            // Keyword Analysis
            Route::get('analyze/{siteId}', [SiteDetailController::class, 'analyzeKeywords']);
            Route::post('details', [SiteDetailController::class, 'getSiteDetails']);

            // Competitor Analysis
            Route::prefix('competitors')->group(function () {
                Route::post('average-history', [SiteDetailController::class, 'averageHistoryReportCompetitor']);
                Route::post('top3', [SiteDetailController::class, 'topThreeMapCompetitor']);
                Route::post('top10', [SiteDetailController::class, 'topTenMapCompetitor']);
                Route::post('search-volume', [SiteDetailController::class, 'competitorsSearchVolumeRanking']);
            });

            // Keyword Position Flow
            Route::get('position-flow/{siteId}', [SiteDetailController::class, 'keywordPositionFlow']);
        });

    // Users Routes (Future Scope)
    Route::prefix('users')->group(function () {
        //
    });
});

// Authentication Routes
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
