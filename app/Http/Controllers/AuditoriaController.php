<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuditoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $bitacoras = Bitacora::latest('fecha')->paginate(10);
    return view('auditoria.index', compact('bitacoras'));
}

}