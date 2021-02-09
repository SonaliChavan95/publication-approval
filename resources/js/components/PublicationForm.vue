<template>
  <div>
    <b-form @submit.prevent="onSubmit" v-if="show">
      <b-form-group label="Title of the publication" label-for="input-1">
        <b-form-input id="input-1" v-model="publication.title" type="text" placeholder="Title of the publication" required>
        </b-form-input>
      </b-form-group>

      <b-form-group label="Abstract" label-for="input-2">
        <b-form-textarea id="input-2" v-model="publication.abstract" placeholder="abstract" required>
        </b-form-textarea>
      </b-form-group>

      <b-form-group label="Description" label-for="input-3">
        <b-form-textarea id="input-3" v-model="publication.description" placeholder="description" required>
        </b-form-textarea>
      </b-form-group>

      <b-form-group label="Primary Author" label-for="input-4">
        <b-form-input id="input-4" v-model="publication.primary_author" type="text" placeholder="Primary Author" required>
        </b-form-input>
      </b-form-group>

      <b-form-group label="Secondary Author" label-for="input-5" >
        <b-form-input id="input-5" v-model="publication.secondary_author" type="text" placeholder="Secondary Author">
        </b-form-input>
      </b-form-group>

      <b-form-group label="Published Date" label-for="input-6">
        <b-form-datepicker id="input-6" v-model="publication.published_at" placeholder="Published Date" required>
        </b-form-datepicker>
      </b-form-group>

      <b-form-group label="URL" label-for="input-7">
        <b-form-input id="input-7" v-model="publication.url" type="text" placeholder="URL">
        </b-form-input>
      </b-form-group>

      <b-form-group label="ISBN" label-for="input-8">
        <b-form-input id="input-8" v-model="publication.isbn" type="text" placeholder="ISBN">
        </b-form-input>
      </b-form-group>

      <b-form-group label="Your name" label-for="input-9">
        <b-form-input id="input-9" v-model="publication.name" type="text" placeholder="Name of the person submitting publication" required>
        </b-form-input>
      </b-form-group>

      <b-form-group label="Your email address" label-for="input-10" description="We'll never share your email with anyone else.">
        <b-form-input id="input-10" v-model="publication.email" type="email" placeholder="Enter email of person submitting publication" required>
        </b-form-input>
      </b-form-group>

      <b-form-group label="Choose a cover image" label-for="input-11" description="Image with image/jpeg, image/png format only">
        <b-form-file id="input-11" v-model="publication.cover_image" :state="Boolean(publication.cover_image)"
          placeholder="Choose a cover image or drop it here..."
          drop-placeholder="Drop file here..."
          accept="image/jpeg, image/png"
          @change="uploadCoverImage"
          required>
        </b-form-file>
      </b-form-group>

      <img src='' height="200" alt="Image preview..." id='preview'>

      <b-form-group label="Choose a publication file" label-for="input-12" description="Files with .doc, .docx, ,application/msword, application/pdf format only">
        <b-form-file id="input-12" v-model="publication.publication_file" :state="Boolean(publication.publication_file)"
        placeholder="Choose a file or drop it here..."
        drop-placeholder="Drop file here..."
        accept=".doc, .docx, ,application/msword, application/pdf"
        required>
        </b-form-file>
      </b-form-group>

      <b-button type="submit" variant="primary">Submit</b-button>
      <b-button type="reset" variant="danger">Reset</b-button>
    </b-form>
  </div>
</template>

<script>
export default {
  props: [],
  components: {

  },
  data: function() {
    return {
      show: true,
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
        cover_image: '',
      }
    }
  },
  methods: {
    onSubmit: async function() {
      let formData = new FormData();
      formData.append("title", this.publication.title);
      formData.append("abstract", this.publication.abstract);
      formData.append("description", this.publication.description);
      formData.append("primary_author", this.publication.primary_author);
      formData.append("secondary_author", this.publication.secondary_author);
      formData.append("published_at", this.publication.published_at);
      formData.append("url", this.publication.url);
      formData.append("isbn", this.publication.isbn);
      formData.append("name", this.publication.name);
      formData.append("email", this.publication.email);
      formData.append("publication_file", this.publication.publication_file);
      formData.append("cover_image", this.publication.cover_image);

      axios.post('api/publications', formData)
        .then((res, status) => {
          console.log(res);
          console.log(status);
          alert(res.data)
          this.$router.push({path: `/`});
        })
        .catch((error) => {
          console.log(error);
        });
    },
    uploadCoverImage: function(e) {
      let reader = new FileReader();
      let files = e.target.files || e.dataTransfer.files;
      const preview = document.getElementById('preview');
      if (!files.length)
        return;

      this.publication.cover_image = files[0];
      reader.onload = (e) => {
        preview.src = e.target.result;
        console.log(`this.resume: ${this.resume}`);
      };
      reader.readAsDataURL(files[0]);
    }
  }
}
</script>

<style scoped>
</style>


