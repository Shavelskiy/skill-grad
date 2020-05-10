<template lang="pug">
  .item.request
    .text {{ formatDate }}
    .text {{ request.author.name }}
    .text
      .top {{ request.author.email }}
      .bottom {{ request.author.phone }}
    .text {{ request.comment }}
    .text
      div(v-if="request.status === 'new'")
        button.reject Откланить
        button.agree Подтвердить
      div(v-else)
        .aree(v-if="request.status === 'agree'") Заявка подтверждена
        .reject(v-else) Заявка отклонена
</template>

<script>
  export default {
    name: 'request-item',
    props: ['request'],
    computed: {
      formatDate: function() {
        const date = new Date(this.request.date);   
        return '25.10.20' + ' ' + date.getHours() + ':' + date.getMinutes();
      },
    },
  }
</script>
