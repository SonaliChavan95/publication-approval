<template>
  <div class='publicationListContainer'>
    <div class='heading'>
      <h1 id='title'>Publication Submission Approval App</h1>
    </div>
    <list-publications :publications='publications' />
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


