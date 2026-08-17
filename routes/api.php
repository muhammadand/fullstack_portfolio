<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ClientProposalController;

// Endpoint Webhook untuk menerima data dari Scraper WhatsApp
Route::post('/webhook/scraper-client', [ClientProposalController::class, 'handleWebhook']);

// Endpoint API untuk Bulk Insert Student Leads
use App\Http\Controllers\Api\StudentLeadApiController;
Route::post('/student-leads/bulk', [StudentLeadApiController::class, 'bulkStore']);
