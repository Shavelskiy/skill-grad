<template lang="pug">
  .chat-content(v-if="messages !== undefined")
    .chat-container(v-for="message in messages")
      div {{ message.senderUsername }}
      .chat-item
        .chat-item-message {{ message.message }}
        .chat-item-date
          span {{ message.dateSend }}
</template>

<script>
  export default {
    name: 'chat',
    props: ['messages'],
  }
</script>