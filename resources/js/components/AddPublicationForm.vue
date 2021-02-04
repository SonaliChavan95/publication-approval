<template>
  <div>
    <div class='item'>
      <form id="signup-form" @submit.prevent="addPublication">
        <label for="title">Title of the publication</label>
        <input type="text" placeholder='Title of the publication' name='title' autofocus required v-model="title">
        <label for="abstract">Abstract</label>
        <textarea name="abstract" rows="5" cols="33" v-model="abstract" />
        <label for="description">Description</label>
        <textarea name="description" rows="5" cols="33" v-model="description" />
        <label for="primary_author">Primary Author</label>
        <input type="text" placeholder='' name='primary_author' v-model="primary_author">
        <label for="secondary_author">Secondary Author</label>
        <input type="text" placeholder='' name='secondary_author' v-model="secondary_author">
        <label for="published_at">Published Date</label>
        <input type="date" placeholder='' name='published_at' v-model="published_at">
        <label for="url">URL</label>
        <input type="text" placeholder='' name='url' v-model="url">
        <label for="isbn">ISBN</label>
        <input type="text" placeholder='' name='isbn' v-model="isbn">
        <label for="name">Name of the person submitting publication</label>
        <input type="text" placeholder='' name='name' v-model="name">
        <label for="email">Email of person submitting publication</label>
        <input type="email" placeholder='' name='email' v-model="email">

        <label for="cover_image">Choose a cover picture</label>
        <input type="file"
        name="cover_image"
        accept="image/png, image/jpeg"
        @change="uploadResume"
        class="form-control-file">
        >

        <!-- Render resume to screen if there is one -->
        <div class="col-12">
            <iframe v-if="cover_image" :src="'https://s3-us-west-1.amazonaws.com/publicationsubmission/' + cover_image"
            width="800px" height="600px" ></iframe>
            <p v-if="!cover_image" class="text-danger">You have not uploaded a cover_image yet</p>
            <p v-if="cover_image" class="text-success">cover_image uploaded successfully</p>
        </div>

        <label for="publication_file">Choose a publication file</label>
        <input type="file"
        name="publication_file"
        accept=".doc, .docx, ,application/msword, .pdf"
        >

        <input type="submit" @click="addPublication()">
      </form>
    </div>
  </div>
</template>

<script>
export default {
  props: [],
  components: {

  },
  data: function() {
    return {
      publication: {
        title: '',
        abstract: '',
        description: '',
        primary_author: '',
        secondary_author: '',
        published_at: '',
        url: '',
        isbn: '',
        name: '',
        email: '',
        publication_file: '',
        cover_image: ''
      }
    }
  },
  methods: {
    addPublication: async function() {
      if(this.publication.title == '') {
        return ;
      }

      axios.post('api/publications', {
        publication: this.publication
      })
      .then(response => {
        if(response.status == 201) {
          alert('Publication submitted successfull. You will receive confirmation email in sometime.')
        }
      })
      .catch(error => {
        alert(error);
      });
    }
  }
}
</script>

<style scoped>
input, textarea {
  border: 1px black solid;
}
</style>


