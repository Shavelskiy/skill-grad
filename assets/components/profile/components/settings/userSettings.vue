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
</template>

<script>
  import {endpoints} from '../../store/endpoints';
  import axios from 'axios';
  import {TheMask} from 'vue-the-mask';
  import categorySelect from './categorySelect';

  export default {
    name: 'userSettings',
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

        axios.post(endpoints.UPDATE_USER_SETTINGS, this.profileSettings)
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
      axios.get(endpoints.GET_USER_SETTINGS)
        .then(response => {
          this.fillUserData(response.data);
          this.disableButton = false;
        });
    }
  }
</script>
