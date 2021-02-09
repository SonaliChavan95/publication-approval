<template>
  <div class='publicationListContainer'>
    <br>
    <b-row align-v="center">
      <b-col class="text-right">
        <b-button to="/add_publication" variant="outline-success" size="sm">Submit New Publication</b-button>
      </b-col>
    </b-row>

    <b-row>
      <b-col>
        <list-publications :publications='publications' />
      </b-col>
    </b-row>

  </div>
</template>

<script>
import ListPublications from './ListPublications';
export default {
  props: [],
  components: {
    ListPublications
  },
  data: function() {
    return {
      publications: []
    }
  },
  methods: {
    async getPublications() {
      try {
        const { data } = await axios.get('api/publications');
        this.publications = data;
      } catch (error) {
        alert(error);
      }
    },
    say: function (message) {
      alert(message)
    }
  },
  created() {
    this.getPublications();
  }
}
</script>

<style scoped>

</style>


