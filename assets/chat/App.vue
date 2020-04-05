<template>
  <div id="app">
    <div v-if="state">kek</div>
    <div v-else>{{ token }}</div>
    <button @click="state = !state">Test vue js</button>
  </div>
</template>

<script>
  const axios = require('axios').default;

  export default {
    name: 'app',
    data: function () {
      return {
        state: true,
        token: '',
      }
    },
    created: function () {
      axios.get('/chat/start')
        .then(response => {
          this.token = response.data.token;

          const socket = new WebSocket('ws://localhost:8081');
          socket.onopen = (e) => {
            socket.send(JSON.stringify({
              type: 'init',
              token: this.token
            }));
          };

          socket.onmessage = function (e) {
            console.log(e.data);
          };
        })
        .catch(error => {
          console.log(error);
        });
    }
  }
</script>

<style>

</style>
