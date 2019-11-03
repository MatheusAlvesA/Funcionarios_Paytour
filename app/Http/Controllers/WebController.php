<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebController extends Controller
{
    public function index(Request $r) {
    	return response("Em desnvolvimento, acesse /api", 200);
    }
}
