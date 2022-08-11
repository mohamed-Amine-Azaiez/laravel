<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\CommandeProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $commandes = Commande::get();
        return response()->json([
            'Commandes' => $commandes
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
                'montant' => 'required', 'lieuLivraison' => 'required', 'prixTotal' => 'required', 'typeLivraison' => 'required', 'modePayment' => 'required', 'deliveryPrice' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()
                ], 500);
            }

            $comproducts = $request->products;
            foreach ($comproducts as $prod) {
                $dbprod = Product::find($prod['id_product']);
                if ($dbprod) {
                    if ($dbprod->quantity < $prod['qte']) {
                        return  response()->json([
                            'message' => 'quantity insufficient',
                            'status_code' => 403,
                        ], 201);
                    }
                } else {
                    return  response()->json([
                        'message' => 'Could not find product with the provided id',
                        'status_code' => 404,
                    ], 201);
                }
            }

            $commande = Commande::create(array_merge($request->all(), ['customer_id' => $userAuth->id], ['date' => now()]));

            $products = $request->products;


            foreach ($products as $prod) {
                CommandeProduct::create(array_merge(['id_product' => $prod['id_product']], ['id_commande' => $commande->id], ['qte' => $prod['qte']]));
                $dbprod = Product::find($prod['id_product']);
                $dbprod->update(['quantity' => $dbprod->quantity - $prod['qte']]);
            };

            return response()->json([
                'message' => 'Commande created',
                'status_code' => 201,
                'commande' => $commande
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
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function show(Commande $commande)
    {
        //
        return response()->json([
            'commande' => $commande
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function edit(Commande $commande)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commande $commande)
    {
        //
        $userAuth = auth('api')->user();
        if ($userAuth && $userAuth->role == 2 && $userAuth->id == $commande->customer_id) {
            $commande->update($request->all());

            return response()->json([
                'message' => 'commande updates',
                'status_code' => 200,
                'data' => $commande
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
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commande $commande)
    {
        //
        $userAuth = auth('api')->user();
        if ($userAuth && $userAuth->role == 2 && $userAuth->id == $commande->customer_id) {
            $commande->delete();

            return response()->json([
                'message' => 'commande deleted',
                'status_code' => 200,
            ], 201);
        } else {
            return response()->json([
                'message' => 'unauthorized'
            ], 401);
        }
    }

    public function getCommandeByIdCustomer($id)
    {
        $commandes = Commande::where('customer_id', "=", $id)->get();
        if ($commandes->isEmpty()) {
            return response()->json(['message' => 'nothing to return'], 404);
        }
        return response()->json([
            'commandes' => $commandes
        ], 200);
    }
}
