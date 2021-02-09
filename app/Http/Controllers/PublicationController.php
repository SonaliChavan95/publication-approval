<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;
use App\Mail\PublicationSubmitted;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PublicationController extends Controller
{
    public function index() {
      // if(user is logged in) {
      //   all
      // } else {
      //   approved
      // }
      $publications = Publication::orderBy('created_at', 'DESC')->get();
      return response($publications->jsonSerialize(), 200);
    }

    public function store(Request $request) {
      if ($request->hasFile('cover_image')) {
        $file = $request->file('cover_image');
        $coverFilePath = Storage::disk('s3')->put(
          'covers/'. time() . '-'. $file->getClientOriginalName(), // file name with location
          $file
        );
      }

      if ($request->hasFile('publication_file')) {
        $file = $request->file('publication_file');
        $filePath = Storage::disk('s3')->put(
          'files/'. time() . '-'. $file->getClientOriginalName(), // file name with location
          $file
        );
      }

      $validatedAttributes = $request->validate([
        'title' => ["required", 'string'],
        'abstract' => ["required", 'string'],
        'description' => ["required", 'string'],
        'primary_author' => ["required", 'string'],
        'secondary_author' => ["nullable", 'string'],
        'published_at' => ["nullable", 'date'],
        'url' => ["nullable", 'string'],
        'isbn' => ["nullable", 'string'],
        'name' => ["required", 'string'],
        'email' => ["required", 'email'],
        'publication_file' => ['required_if:url,null'],
        'cover_image' => ["required", 'max:255']
      ]);

      $validatedAttributes['cover_image'] = $coverFilePath;
      $validatedAttributes['publication_file'] = $filePath;
      $newPublication = Publication::create($validatedAttributes);

      Mail::to($newPublication->email)->send(new PublicationSubmitted($newPublication));

      return response($newPublication, 201);
    }

    public function show($id)
    {
      if (!Publication::where('id', $id)->exists()) {
        return response()->json([
          "message" => "Publication not found"
        ], 404);
      }
      $publication = Publication::where('id', $id)->first();
      $publication->current_user = true;
      $publication->temp_cover = Storage::disk('s3')->temporaryUrl($publication->cover_image, now()->addMinutes(10));
      if($publication->publication_file)
        $publication->temp_file = Storage::disk('s3')->temporaryUrl($publication->publication_file, now()->addMinutes(10));
      return response($publication, 200);
    }

    public function update(Request $request, $id) {
      if (!Publication::where('id', $id)->exists()) {
        return response()->json([
          "message" => "publication not found"
        ], 404);
      }

      $publication = Publication::find($id);

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
        'publication.publication_file' => ['required_if:url,null'],
        'publication.cover_image' => ["required", 'max:255']
      ])['publication'];

      $publication::update($validatedAttributes);
      return response()->json($publication, 200);
    }

    public function approve(Publication $publication) {
      $publication->approve = true;
      $publication->save();

      return response()->json([
        "message" => "Publication approved"
      ], 200);
    }

    public function reject(Publication $publication) {
      $publication->approve = false;
      $publication->save();
      return response()->json([
        "message" => "Publication rejected"
      ], 200);
    }
}
