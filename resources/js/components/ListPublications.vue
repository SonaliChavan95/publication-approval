<template>
  <div>
    <header class="header" v-show="publications.length" v-cloak>
      <div class="row">
        <div class="col-md-3">
          <b-form-select v-model="selected" :options="options" size="sm"></b-form-select>
        </div>
        <div class="col-md-2 offset-7 text-right">
          <span class="publication-count">
            <strong>{{ publications.length }}</strong> {{ publications.length | pluralize }}
          </span>
        </div>
      </div>
      <br>
    </header>

    <section class="main" v-show="publications.length" v-cloak role="tablist">
      <div class="overflow-auto">
        <b-list-group id="my-table" v-for="publication in filteredPublications" :key="publication.id" small>
          <b-list-group-item :to="{ name: 'ShowPublication', params: { id: publication.id }}" class="flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{publication.title}}</h5>
              <small>{{publication.published_at}}</small>
            </div>

            <p class="mb-1">
              {{publication.abstract}}
            </p>

            <small>Submitted by {{publication.name}}</small>
          </b-list-group-item>
        </b-list-group>
      </div>
    </section>
  </div>
</template>

<script>
import ListPublication from './ListPublication';

export default {
  props: ['publications'],
  components: {
    ListPublication
  },
  data: function() {
    return {
      selected: 'al',
      options: [
        { value: 'al', text: 'All' },
        { value: 'a', text: 'Approved' },
        { value: 'r', text: 'Rejected' },
        { value: null, text: 'Awaiting' },
      ]
    }
  },
  methods: {
  },
  computed: {
    filteredPublications: function() {
      // console.log("--1---");
      // return filters[this.visibility](this.publications);
      switch(this.selected){
        case 'a':
          return this.publications.filter(publication => publication.approve);
        case 'r':
          return this.publications.filter(publication => publication.approve == false);
        case null:
          return this.publications.filter(publication => publication.approve == null);
        default:
          return this.publications;
      }
    }
  },

  filters: {
    pluralize: function(n) {
      return n === 1 ? "publication" : "publications";
    }
  },
}
</script>

<style scoped>
[v-cloak] {
  display: none;
}
</style>


