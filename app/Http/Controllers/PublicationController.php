<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;
use App\Mail\PublicationSubmitted;
use Illuminate\Support\Facades\Mail;

class PublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if(user is logged in) {
        //   all
        // } else {
        //   approved
        // }
        $publications = Publication::orderBy('created_at', 'DESC')->get();
        return response($publications->jsonSerialize(), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //
      // dd($request->publication['title']);
      // dd($request->input('publication.title'));
      // $input = $request->only(['publication.title', 'publication.abstract']);
      // dd($input);
      // $newPublication = new Publication;
      // $newPublication->title = $request->publication['title'];
      // $newPublication->save();

      $validatedAttributes = $request->validate([
        'publication.title' => ["required", 'string'],
        'publication.abstract' => ["required", 'string'],
        'publication.description' => ["required", 'string'],
        'publication.primary_author' => ["required", 'string'],
        'publication.secondary_author' => ["nullable", 'string'],
        'publication.published_at' => ["nullable", 'date'],
        'publication.url' => ["nullable", 'string'],
        'publication.isbn' => ["nullable", 'string'],
        'publication.name' => ["required", 'string'],
        'publication.email' => ["required", 'email'],
        // 'publication.publication_file' => ['required_if:url,null'],
        'publication.cover_image' => ["required", 'max:255']
      ])['publication'];
      // 'photo' => 'mimes:jpg,bmp,png'
      // 'video' => 'mimetypes:video/avi,video/mpeg,video/quicktime' -> file

      // $errors = $validator->errors();
      // dd($errors->first());

      // dd($validatedAttributes);
      // dd($request->publication);

      $newPublication = Publication::create($validatedAttributes);

      Mail::to($newPublication->email)->send(new PublicationSubmitted($newPublication));

      return response($newPublication->jsonSerialize(), 201);
      return response()->json($newPublication, 201);
      // return response()->json([
      //   "message" => "student record created"
      // ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    // public function show(Publication $publication)
    public function show($id)
    {
      if (!Publication::where('id', $id)->exists()) {
        return response()->json([
          "message" => "Publication not found"
        ], 404);
      }
      $publication = Publication::where('id', $id)->get();
      return response($publication, 200);
      // return $publication;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function edit(Publication $publication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Publication $publication) {
    // public function update(Request $request, $id) {
      if (!Publication::where('id', $id)->exists()) {
        return response()->json([
          "message" => "publication not found"
        ], 404);
      }

      $publication = Publication::find($id);
      // $publication->title = is_null($request->title) ? $publication->title : $request->title;
      // $publication->abstract = is_null($request->abstract) ? $publication->abstract : $request->abstract;
      // $publication->save();

      $validatedAttributes = $request->validate([
        'publication.title' => ["required", 'string'],
        'publication.abstract' => ["required", 'string'],
        'publication.description' => ["required", 'string'],
        'publication.primary_author' => ["required", 'string'],
        'publication.secondary_author' => ["nullable", 'string'],
        'publication.published_at' => ["nullable", 'date'],
        'publication.url' => ["nullable", 'string'],
        'publication.isbn' => ["nullable", 'string'],
        'publication.name' => ["required", 'string'],
        'publication.email' => ["required", 'email'],
        // 'publication.publication_file' => ['required_if:url,null'],
        'publication.cover_image' => ["required", 'max:255']
      ])['publication'];

      $publication::update($validatedAttributes);
      // return $publication;
      return response()->json($publication, 200);
      // return response()->json([
      //   "message" => "records updated successfully"
      // ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    // public function destroy(Publication $publication)
    // {
    //     //
    // }

    public function approve(Publication $publication) {
      // $publication->approve(true);
      $publication->approve = true;
      $publication->save();

      return response()->json([
        "message" => "Publication approved"
      ], 200);
    }

    public function reject(Publication $publication) {
      // $publication->reject(false);
      $publication->approve = false;
      $publication->save();
      return response()->json([
        "message" => "Publication rejected"
      ], 200);
    }
}
