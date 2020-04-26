<template lang="pug">
  #profile-app
    .profile
      h1 Личный кабинет провайдера
      .profile-menu
        router-link(:to="{ name: 'settings'}" v-slot="{ href, navigate, isActive }")
          div(:class="isActive ? 'profile-menu-item profile-menu-item-active' : 'profile-menu-item'")
            a(:href="href" @click="navigate") Настройки профиля

        router-link(:to="{ name: 'programs'}" v-slot="{ href, navigate, isActive }")
          div(:class="isActive ? 'profile-menu-item profile-menu-item-active' : 'profile-menu-item'")
            a(:href="href" @click="navigate") Программы обучения


        router-link(:to="{ name: 'publications'}" v-slot="{ href, navigate, isActive }")
          div(:class="isActive ? 'profile-menu-item profile-menu-item-active' : 'profile-menu-item'")
            a(:href="href" @click="navigate") Публикации


        router-link(:to="{ name: 'messages'}" v-slot="{ href, navigate, isActive }")
          div(:class="isActive ? 'profile-menu-item profile-menu-item-active' : 'profile-menu-item'")
            a(:href="href" @click="navigate") Сообщения


        router-link(:to="{ name: 'services'}" v-slot="{ href, navigate, isActive }")
          div(:class="isActive ? 'profile-menu-item profile-menu-item-active' : 'profile-menu-item'")
            a(:href="href" @click="navigate") Платные услуги, документы

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
