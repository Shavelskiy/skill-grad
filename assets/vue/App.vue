<template>
  <div id="app">
    <div v-if="state">kek</div>
    <div v-else>lol</div>
    <button @click="state = !state">Test vue js</button>
  </div>
</template>

<script>

  export default {
    name: 'app',
    data: function () {
      return {
        state: true
      }
    }
  }
</script>

<style>

</style>
