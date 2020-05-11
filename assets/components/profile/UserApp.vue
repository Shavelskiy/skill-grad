<template lang="pug">
  #profile-app
    .profile
      h1 Личный кабинет провайдера
      .profile-menu
        router-link(:to="{ name: 'settings'}" v-slot="{ href, navigate, isActive }")
          div(:class="isActive ? 'profile-menu-item profile-menu-item-active' : 'profile-menu-item'")
            a(:href="href" @click="navigate") Настройки профиля

        router-link(:to="{ name: 'messages'}" v-slot="{ href, navigate, isActive }")
          div(:class="isActive ? 'profile-menu-item profile-menu-item-active' : 'profile-menu-item'")
            a(:href="href" @click="navigate") Сообщения

      .profile-content
        router-view
</template>

<script>
  const axios = require('axios').default;

  export default {
    name: 'app',
    data: function () {
      return {}
    },
    methods: {},
    created: function () {

    }
  }
</script>

<style>

</style>
