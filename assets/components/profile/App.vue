<template>
  <div id="profile-app">
    <div class="profile">
      <div class="profile-menu">
        <ul>
          <li>
            <router-link :to="{ name: 'kek'}">kek</router-link>
          </li>
          <li>
            <router-link :to="{ name: 'lol'}">lol</router-link>
          </li>
        </ul>
      </div>
      <div class="profile-content">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>

<script>
  const axios = require('axios').default;

  export default {
    name: 'app',
    data: function () {
      return {

      }
    },
    methods: {

    },
    created: function () {
      // axios.get('/chat/start')
      //   .then(response => {
      //
      //   })
      //   .catch(error => {
      //     console.log(error);
      //   });
    }
  }
</script>

<style>

</style>
