<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FactureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $factures = Facture::get();
        return response()->json([
            'factures' => $factures
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $userAuth = auth('api')->user();
        if ($userAuth && $userAuth->role == 2) {
            $validator = Validator::make($request->all(), [
                'refFacture' => 'unique:factures|required', 'remise' => 'required', 'total' => 'required', 'description' => 'required', 'commande_id' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()
                ], 500);
            }

            $facture = Facture::create($request->all());

            return response()->json([
                'message' => 'Facture created',
                'status_code' => 201,
                'data' => $facture
            ], 201);
        } else {
            return response()->json([
                'message' => 'unauthorized'
            ], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function show(Facture $facture)
    {
        //
        return response()->json([
            'facture' => $facture
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function edit(Facture $facture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Facture $facture)
    {
        //
        $userAuth = auth('api')->user();
        if ($userAuth && $userAuth->role == 2) {
            $validator = Validator::make($request->all(), [
                'refFacture' => 'unique:factures',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()
                ], 500);
            }
            $facture->update($request->all());

            return response()->json([
                'message' => 'facture updates',
                'status_code' => 200,
                'data' => $facture
            ], 201);
        } else {
            return response()->json([
                'message' => 'unauthorized'
            ], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Facture $facture)
    {
        //
        $facture->delete();

        return response()->json([
            'message' => 'facture deleted',
            'status_code' => 200,
        ], 201);
    }
}
