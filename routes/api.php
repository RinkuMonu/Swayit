<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InfluencerController;


Route::get('/live-influencer-search', [InfluencerController::class, 'fetchInfluencers']);
Route::post('/notify-influencers', [InfluencerController::class, 'notifyInfluencers']);

