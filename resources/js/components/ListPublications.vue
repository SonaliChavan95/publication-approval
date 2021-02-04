<template>
  <div>
    <header class="header" v-show="publications.length" v-cloak>
      <span class="publication-count">
        <strong>{{ remaining }}</strong> {{ remaining | pluralize }} left
      </span>
      <ul class="filters">
        <li>
          <a href="#/all" :class="{ selected: visibility == 'all' }">All</a>
        </li>
        <li>
          <a href="#/approved" :class="{ selected: visibility == 'approved' }">Approved</a>
        </li>
        <li>
          <a
            href="#/rejected"
            :class="{ selected: visibility == 'rejected' }"
            >Rejected</a
          >
        </li>
        <li>
          <a
            href="#/awaiting"
            :class="{ selected: visibility == 'awaiting' }"
            >Awaiting</a
          >
        </li>
      </ul>
      <!-- <button
        class="clear-completed"
        @click="removeCompleted"
        v-show="publications.length > remaining"
      >
        Clear completed
      </button> -->
    </header>

    <section class="main" v-show="publications.length" v-cloak>
      <ul class="publication-list">
        <li
          v-for="publication in filteredPublications"
          class="publication"
          :key="publication.id"
          :class="{ completed: publication.status }"
        >
          <list-publication
            :item="publication"
            class='item'
          />
        </li>
      </ul>
    </section>
    <!-- <div v-for="(publication) in publications" :key="publication.id">
      <list-publication
        :item="publication"
        class='item'
      />
    </div> -->
  </div>
</template>

<script>
import ListPublication from './ListPublication';

// visibility filters
var filters = {
  all: function(publications) {
    return publications;
  },
  approved: function(publications) {
    // console.log("-------");
    // console.log(publications.filter(publication => publication.status));
    // return publications.filter(publication.status);
    return publications.filter(function(publication) {
      // return publication.approved;
      return publication.status;
    });
  },
  rejected: function(publications) {
    return publications.filter(function(publication) {
      // return !publication.approved;
      return !publication.status;
    });
  },
  awaiting: function(publications){
    return publications.filter(function(publication) {
      // return publication.approved === null ;
      return publication.status === null;
    });
  }
};

function pushHash (path) {
  console.log("push hash");
  if (supportsPushState) {
    pushState(getUrl(path));
  } else {
    window.location.hash = path;
  }
}

function onHashChange() {
    console.log("on hash change");

        var visibility = window.location.hash.replace(/#\/?/, "");
        debugger
        if (filters[visibility]) {
          app.visibility = visibility;
        } else {
          window.location.hash = "";
          app.visibility = "all";
        }
      }

      window.addEventListener("hashchange", onHashChange);
      onHashChange();

export default {
  props: ['publications'],
  components: {
    ListPublication
  },
  data: function() {
    return {
      visibility: "all"
    }
  },
  methods: {
  },
  // computed properties
  // http://vuejs.org/guide/computed.html
  computed: {
    filteredPublications: function() {
      console.log("--1---");
      return filters[this.visibility](this.publications);
      // return this.publications;
    },
    remaining: function() {
      console.log(filters);
      return filters.awaiting(this.publications).length;
    },
    allDone: {
      get: function() {
        return this.remaining === 0;
      },
      set: function(value) {
        this.publications.forEach(function(publication) {
          publication.rejected = value;
        });
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


