<template>
  <div id="profile-app">
    <div class="profile">
      <div class="profile-menu">
        <ul>
          <li>
            <router-link :to="{ name: 'settings'}">Настройки профиля</router-link>
          </li>
          <li>
            <router-link :to="{ name: 'programs'}">Программы обучения</router-link>
          </li>
          <li>
            <router-link :to="{ name: 'publications'}">Публикации</router-link>
          </li>
          <li>
            <router-link :to="{ name: 'messages'}">Сообщения</router-link>
          </li>
          <li>
            <router-link :to="{ name: 'services'}">Платные услуги, документы</router-link>
          </li>
          <li>
            <router-link :to="{ name: 'training'}">Мое обучение</router-link>
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

    }
  }
</script>

<style>

</style>
