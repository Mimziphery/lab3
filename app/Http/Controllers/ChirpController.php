<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //return 'Hello, World!';
        //return view('chirps.index');
        return view('chirps.index', [
            'chirps' => Chirp::with('user')->latest()->get(),
        ]);
    }

    public function home()
    {
        //
        // return 'Hello, World!';
        //return view('chirps.index');
        return view('chirps.index', [
            'chirps' => Chirp::with('user')->latest()->take(3)->get(),
        ]);
    }

    public function all()
    {
        //
        // return 'Hello, World!';
        //return view('chirps.index');
        return view('chirps.index', [
            'chirps' => Chirp::with('user')->get(),
        ]);
    }

    
    public function getGallery()
    {
        //
        // return 'Hello, World!';
        return view('chirps.gallery');
        // return view('chirps.index', [
        //     'chirps' => Chirp::with('user')->latest()->get(),
        // ]);
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

        $chirp = new Chirp;
        if($request->file('image')){
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('images'), $filename);
            $chirp['image']= $filename;
        }

        $validated = $request->validate([
            'message' => 'required|string|max:255'
        ]);

        // $chirp['message']= $_POST['message'];
        // $request->user()->chirps();
        //$chirp->save();


        // if($request->hasFile('image')){
        //     $fileNameWithExt = $request->file('image')->getClientOriginalName();
        //     $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        //     $extension = $request->file('image')->getClientOriginalExtension();
        //     $fileNameToStore = $filename .'_'.time().'.'.$extension;
        //     $path = $request->file('image')->storeAs('public/images', $fileNameToStore);

        // }else{
        //     $fileNameToStore = 'noimage.jpeg';

        // }
 
        $request->user()->chirps()->create($validated);
 
        return redirect(route('chirps.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chirp  $chirp
     * @return \Illuminate\Http\Response
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Chirp  $chirp
     * @return \Illuminate\Http\Response
     */
    public function edit(Chirp $chirp)
    {
        //
        $this->authorize('update', $chirp);
 
        return view('chirps.edit', [
            'chirp' => $chirp,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Chirp  $chirp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chirp $chirp)
    {
        //
        $this->authorize('update', $chirp);
 
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);
 
        $chirp->update($validated);
 
        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chirp  $chirp
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chirp $chirp)
    {
        //
        $this->authorize('delete', $chirp);
 
        $chirp->delete();
 
        return redirect(route('chirps.index'));
    }
}
