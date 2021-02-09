<template>
  <div>
    <div class="publication" v-if="loading">
      Loading publication.
    </div>
    <div class="publication" v-else>
      <div v-if="publication">
        <div class="row text-right">
          <div class="col-md-12">
            <div v-if="publication.current_user">
              <a @click="rejectPublication" v-if="publication.approve == 1 || publication.approve == null" class="btn btn-outline-danger" rel="noopener noreferrer">Reject</a>
              <a @click="approvePublication"  v-if="publication.approve == 0 || publication.approve == null" class="btn btn-outline-success" rel="noopener noreferrer">Approve</a>
              <router-link :to="{ name: 'EditPublication', params: { id: publication.id }}" class="btn btn-outline-info" rel="noopener noreferrer">Edit</router-link>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <h1>{{publication.title}}
            <b-badge variant="success" class="status" v-if="publication.approve == 1">Approved</b-badge>
            <b-badge variant="danger" class="status" v-if="publication.approve == 0">Rejected</b-badge>
            </h1>
          </div>
          <div class="col-md-12">
            <img :src='publication.temp_cover' alt="" height="300">
          </div>
          <div class="col-md-12">
            <strong>Abstract</strong>
            <p>{{publication.abstract}}</p>
            <strong>Description</strong>
            <p>{{publication.description}}</p>
            <strong>URL</strong>
            <p>{{publication.url || 'N/A'}}</p>
            <strong>ISBN</strong>
            <p>{{publication.isbn || 'N/A'}}</p>
            <strong>Primary Author</strong>
            <p>{{publication.primary_author}}</p>
            <strong>Secondary Author</strong>
            <p>{{publication.secondary_author || 'N/A'}}</p>
            <strong>Publication Date</strong>
            <p>{{publication.published_at}}</p>
            <strong>Submitted by</strong>
            <p>{{publication.name || 'N/A'}}</p>


            <div v-if="publication.publication_file === null"> File not available </div>
            <div v-else>
              <a :href="publication.temp_file" target="_blank">Publication File</a>
            </div>

          </div>
        </div>
      </div>
      <div v-else>
        Publication not found
      </div>
    </div>
  </div>
</template>

<script>
export default {
  components: {

  },
  data: function() {
    return {
      show: true,
      publication: '',
      loading: true,
    }
  },
  methods: {
    async getPublication(id) {
      try {
      let response = await axios.get(`/api/publications/${id}`);
      this.publication = response.data;
      // alert(response.status);

      } catch (e){
        console.log(e);
      }
      this.loading = false;
    },
    approvePublication: async function() {
      const id = this.$route.params.id;
      axios.get(`/api/publications/${id}/approve`);
      this.publication.approve = true
    },
    rejectPublication: async function() {
      const id = this.$route.params.id;
      axios.get(`/api/publications/${id}/reject`);
      this.publication.approve = false
    }
  },
  mounted() {
    this.getPublication(this.$route.params.id);
  }
}
</script>

<style scoped>
.status {
  font-size: small;
}
</style>


