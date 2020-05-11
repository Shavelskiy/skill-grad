<template lang="pug">
  #profile-app
    .profile
      h1 Личный кабинет обучающегося
      .profile-menu
        menu-item(v-bind:route="'settings'" v-bind:text="'Настройки профиля'")
        menu-item(v-bind:route="'messages'" v-bind:text="'Сообщения'")
        menu-item(v-bind:route="'training'" v-bind:text="'Мое обучение'")
      .profile-content
        router-view
</template>

<script>
  import menuItem from './components/menuItem';

  export default {
    name: 'userApp',
    components: {
      menuItem,
    },
  }
</script>
