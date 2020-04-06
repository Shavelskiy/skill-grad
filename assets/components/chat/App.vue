<template>
  <div id="app">
    <div class="chat">
      <div class="chat-tabs">
        <button
                v-for="user in users"
                v-on:click="activeUserId = user.id"
                :class="`chat-btn ${(user.id === activeUserId) ? 'chat-btn__active' : ''}`"
        >
          {{ user.username }}
          <span class="chat-tabs-type" v-if="typingUserIds.includes(user.id)">
            ...печатает
          </span>
        </button>
      </div>
      <messages :messages="allMessages[activeUserId]" :key="messagesKey"></messages>
      <input type="text" class="chat-input" placeholder="Введите сообщение"
             @keyup.enter="sendMessage"
             v-model="message"
             v-on:focusin="focusIn"
             v-on:focusout="focusOut">
      <span v-if="typingUserIds.includes(activeUserId)">...печатает</span>
    </div>
  </div>
</template>

<script>
  const axios = require('axios').default;
  import messages from './messages';

  export default {
    name: 'app',
    components: {
      messages,
    },
    data: function () {
      return {
        messagesKey: 1,
        userId: null,
        token: '',
        activeUserId: null,
        typingUserIds: [],
        users: [],
        socket: null,
        message: null,
        allMessages: {},
      }
    },
    methods: {
      focusIn: function () {
        this.socket.send(JSON.stringify({
          type: 'focusIn',
          userId: this.activeUserId,
        }));
      },
      focusOut: function () {
        this.socket.send(JSON.stringify({
          type: 'focusOut',
          userId: this.activeUserId,
        }));
      },
      sendMessage: function () {
        if (this.message !== null) {
          this.socket.send(JSON.stringify({
            type: 'sendMessage',
            to: this.activeUserId,
            message: this.message
          }));

          this.message = null;
        }
      },
    },
    created: function () {
      axios.get('/chat/start')
        .then(response => {
          this.userId = response.data.userId;
          this.token = response.data.token;
          this.users = response.data.users;

          this.allMessages = response.data.messages;

          this.activeUserId = this.users[0].id;

          this.socket = new WebSocket('ws://localhost:8081');

          this.socket.onopen = () => {
            this.socket.send(JSON.stringify({
              type: 'init',
              token: this.token
            }));
          };

          this.socket.onmessage = (e) => {
            const data = JSON.parse(e.data);

            switch (data.type) {
              case 'focusIn':
                const userFromInId = Number(data.from);
                if (!this.typingUserIds.includes(userFromInId)) {
                  this.typingUserIds.push(userFromInId);
                }
                break;
              case 'focusOut':
                const userFromOutId = Number(data.from);

                this.typingUserIds = this.typingUserIds.filter((item) => {
                  return item !== userFromOutId;
                });
                break;
              case 'sendMessage':
                if (this.allMessages[data.withId] === undefined) {
                  this.allMessages[data.withId] = [];
                }

                this.allMessages[data.withId].push(data.message);
                this.messagesKey++;
                break;
            }
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
