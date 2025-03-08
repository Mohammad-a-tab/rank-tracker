<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Site\SiteController;
use App\Http\Controllers\Api\V1\Keyword\KeywordController;

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

Route::group(['middleware' => 'auth:sanctum'], function() {
    // keywords
    Route::group(['prefix' => 'keywords'], function () {
        Route::post ('import'                       , [KeywordController::class, 'importKeyword'])->middleware('permission:import keyword');
        Route::get  ('top3'                         , [KeywordController::class, 'keywordTop3'])->middleware('permission:keyword top 3');
        Route::get  ('top10'                        , [KeywordController::class, 'keywordTop10'])->middleware('permission:keyword top 10');
        Route::get  ('progress'                     , [KeywordController::class, 'keywordProgress'])->middleware('permission:keyword progress');
        Route::get  ('get-all'                      , [KeywordController::class, 'getAllKeywords'])->middleware('permission:get all keywords');
        Route::post ('average-position'             , [KeywordController::class, 'averagePosition'])->middleware('permission:get-average-position');
        Route::get  ('search-volume-sites'          , [KeywordController::class, 'competitorsSearchVolumeRankingWithAllSites'])->middleware('permission:search-volume-sites');
        Route::get  ('competitors-top1'             , [KeywordController::class, 'competitorsTopOneMapToday'])->middleware('permission:get-competitors-top-one');
        Route::get  ('competitors-top3'             , [KeywordController::class, 'competitorsTopThreeMapToday'])->middleware('permission:get-competitors-top-three');
        Route::get  ('competitors-top10'            , [KeywordController::class, 'competitorsTopTenMapToday'])->middleware('permission:get-competitors-top-ten');
        Route::post ('competitors-average'          , [KeywordController::class, 'competitorsAverageMapToday'])->middleware('permission:competitors-average');
        Route::get  ('analyze'                      , [KeywordController::class, 'analyzeKeywords'])->middleware('permission:analyze-keywords');
        Route::post ('position-distribution'        , [KeywordController::class, 'keywordPositionDistribution'])->middleware('permission:keyword-position-distribution');
        Route::get  ('average-history-competitor'   , [KeywordController::class, 'averageHistoryReportCompetitor'])->middleware('permission:average-history-report-competitor');
        Route::get  ('top1-competitor'              , [KeywordController::class, 'topOneMapCompetitor'])->middleware('permission:get-top-one-competitor');
        Route::get  ('top3-competitor'              , [KeywordController::class, 'topThreeMapCompetitor'])->middleware('permission:get-top-three-competitor');
        Route::get  ('top10-competitor'             , [KeywordController::class, 'topTenMapCompetitor'])->middleware('permission:get-top-ten-competitor');
        Route::get  ('analyze-competitor'           , [KeywordController::class, 'analyzeKeywordsCompetitor'])->middleware('permission:analyze-keywords-competitor');
        Route::post ('losers-winners'               , [KeywordController::class, 'losersWinners'])->middleware('permission:get-losers-winners');
        Route::get  ('search-volume'                , [KeywordController::class, 'competitorsSearchVolumeRanking'])->middleware('permission:competitors-search-volume-ranking');
        Route::get  ('gainers-losers-increased'     , [KeywordController::class, 'gainersLosersIncreased'])->middleware('permission:get-gainers-losers');
        Route::get  ('gainers-losers-decreased'     , [KeywordController::class, 'gainersLosersDecreased'])->middleware('permission:get-gainers-losers');
        Route::get  ('position-flow'                , [KeywordController::class, 'keywordPositionFlow'])->middleware('permission:get-position-flow');
    });

    // sites
    Route::group(['prefix' => 'sites'], function () {
        Route::get  ('get-all'              , [SiteController::class, 'getAllSites'])->middleware('permission:get all sites');
        Route::get  ('monthly-progress'     , [SiteController::class, 'monthlyProgress'])->middleware('permission:month progress');
        Route::get  ('get-title'            , [SiteController::class, 'getTitleForUrlSite'])->middleware('permission:get title site');
        Route::post ('import'               , [SiteController::class, 'importSiteUrl'])->middleware('permission:import site');
    });

    // users
    Route::group(['prefix' => 'users'], function () {
        //
    });
});

Route::post ('login'    , [AuthController::class, 'login']);
Route::post ('logout'   , [AuthController::class, 'logout']);
