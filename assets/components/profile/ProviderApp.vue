<template lang="pug">
  #profile-app
    .profile
      h1 Личный кабинет провайдера
      .profile-menu
        menu-item(v-bind:route="'settings'" v-bind:text="'Настройки профиля'")
        menu-item(v-bind:route="'programs'" v-bind:text="'Программы обучения'")
        menu-item(v-bind:route="'publications'" v-bind:text="'Публикации'")
        menu-item(v-bind:route="'messages'" v-bind:text="'Сообщения'")
        menu-item(v-bind:route="'services'" v-bind:text="'Платные услуги, документы'")
      .profile-content
        router-view
</template>

<script>
  import menuItem from './components/menuItem';

  export default {
    name: 'providerApp',
    components: {
      menuItem,
    },
  }
</script>
