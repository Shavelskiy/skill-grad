<template>
  <div class="chat-content" v-if="messages !== undefined">
    <div class="chat-container" v-for="message in messages">
      <div>
        {{ message.senderUsername }}
      </div>
      <div class="chat-item">
        <div class="chat-item-message">
          {{ message.message }}
        </div>
        <div class="chat-item-date">
          <span>{{ message.dateSend }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'messages',
    props: ['messages'],
  }
</script>