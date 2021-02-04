<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('abstract');
            $table->text('description');
            $table->string('primary_author');
            $table->string('secondary_author')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->string('url')->nullable();
            $table->string('isbn')->nullable();
            $table->string('name');
            $table->string('email');
            $table->boolean('approve')->nullable();
            $table->string('publication_file')->nullable();
            $table->string('cover_image');
            $table->timestamps();

            // Title, Abstract,Description, Primary Author, Secondary Author, Publication Date, url, ISBN, Name and email
            // TODO: need to add indexes
            // TODO: validation on email, url, image type, file type, title length
            // TODO: mass assignment while editing
            // TODO: how to update status? new action or use create ew action with mass assignment restriction?
            // TODO: when publication gets approved set published_at date
            // TODO: sort record by published at date on index page
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publications');
    }
}
