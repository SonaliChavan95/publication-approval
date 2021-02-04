<template>
  <div>
    <div class='item'>
      <div v-for="(value, name, index) in item" :key="index">
        {{ name }}: {{ value }}
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['item'],
  components: {

  },
  data: function() {
    return {
      visibility: 'all'
    }
  },
  methods: {
  }
}
</script>

<style scoped>
.item {
}
</style>


