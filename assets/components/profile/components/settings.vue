<template lang="pug">
  div
    h3 Настройки пользователя
    hr
    .settings-profile
      .settings-profile-row-top
        div
          input.input(
            placeholder="ФИО"
            v-model="profileSettings.fullName"
          )
        div
        div
          input.input(
            type="email"
            placeholder="E-mail"
            v-model="profileSettings.email"
          )
        div
        div
          the-mask.input(
            :mask="'+7 (###)-###-##-##'"
            placeholder="+7 (___)-___-__-__"
            v-model="profileSettings.phone"
          )
      .settings-profile-row-bottom
        div
          input.input(
            type="password"
            placeholder="Старый пароль"
            v-model="profileSettings.oldPassword"
          )
        div
        div
          input.input(
            type="password"
            placeholder="Новый пароль"
            v-model="profileSettings.newPassword"
          )
        div
        div
          input.input(
            type="password"
            placeholder="Повторите новый пароль"
            v-model="profileSettings.confirmNewPassword"
          )
        div
        div
          button.btn.btn-blue(v-on:click="updateProfileSettings" :disabled="disableButton") Сохранить настройки

    h3 Настройки организации
    hr
    .settings-organization
      .settings-organization-logo
        img(:src="organizationSettings.image" v-if="hasLogoImage()")
        img(src="../images/organization-logo.png" v-else)
        .settings-organization-logo-buttons
          label.upload-btn(for="organization-logo") {{ !hasLogoImage() ? 'Загрузить' : 'Изменить' }}
          input(type="file" id="organization-logo" style="display: none" v-on:change="loadImage")
          button.upload-btn-remove(
            type="button"
            :disabled="!hasLogoImage()"
            v-on:click=""
          ) Удалить
      div
        input.input(type="text" placeholder="Настройки организации")
        textarea.textarea.settings-organization-description(
          rows="10"
          placeholder="Описание организации"
        )
      div
    p Выберите основные категории программ обучения (не более 3-х) и подкатегорий (Без ограничений): *
    .settings-categories
      category-select
      div
      category-select
      div
      category-select
      div
</template>

<script>
  import {TheMask} from 'vue-the-mask';
  import categorySelect from './include/categorySelect';

  const axios = require('axios').default;

  export default {
    name: 'settings',
    components: {
      TheMask,
      categorySelect,
    },
    data: function () {
      return {
        disableButton: true,
        profileSettings: {
          fullName: '',
          email: '',
          phone: '',
          oldPassword: '',
          newPassword: '',
          confirmNewPassword: '',
        },
        organizationSettings: {
          image: '',
        },
      };
    },
  methods: {
      updateProfileSettings: function () {
        this.disableButton = true;

        axios.post('/api/profile/settings/', this.profileSettings)
          .then(response => {
            this.fillUserData(response.data);
            this.disableButton = false;
          })
      },
      fillUserData: function (data) {
        this.profileSettings.fullName = data.fullName;
        this.profileSettings.email = data.email;
        this.profileSettings.phone = data.phone;
      },
      loadImage: function (e) {
        const files = e.target.files || e.dataTransfer.files;
        if (!files.length) {
          return;
        }

        const reader = new FileReader();

        reader.onload = (e) => {
          this.organizationSettings.image = e.target.result;
        };

        reader.readAsDataURL(files[0]);
      },
      hasLogoImage: function () {
        return this.organizationSettings.image.length !== 0;
      },
      deleteLogoImage: function () {
        this.organizationSettings.image = '';
      }
    },
    created() {
      axios.get('/api/profile/settings/')
        .then(response => {
          this.fillUserData(response.data);
          this.disableButton = false;
        });
    }
  }
</script>
