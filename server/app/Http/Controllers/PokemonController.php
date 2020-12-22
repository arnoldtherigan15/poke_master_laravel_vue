<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PokemonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        $pokemons = Auth::user()->pokemon;
        $response = [
            'message' => 'Pokemon lists',
            'data' => $pokemons
        ];
        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // ada dua cara
        // $pokemon = $request->user()->pokemon()->create($request->all());
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'img_url' => 'required'
        ]);
        if($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }
        $pokemon = Auth::user()->pokemon()->create($request->all());
        $response = [
            'message' => 'Pokemon Created',
            'data' => $pokemon
        ];
        return response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pokemon = Pokemon::find($id);
        $response = [
            'message' => 'Pokemon Detail',
            'data' => $pokemon
        ];
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $pokemon = Pokemon::find($id);
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'img_url' => 'required'
        ]);
        if($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }
        Auth::user()->pokemon()->where('id',$id)->first()->update($request->all());
        $response = [
            'message' => 'Pokemon with id:'. $id .' updated'
        ];
        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pokemon = Pokemon::destroy($id);
        $response = [
            'message' => 'Pokemon with id:'. $id .' Deleted',
            'data' => $pokemon
        ];
        return response()->json($response, 200);
    }
}
