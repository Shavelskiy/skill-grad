<template lang="pug">
  div
    button.input(
      v-on:click="toggleOptions()"
    ) {{ (selectedValue !== null) ? selectedValue.title : 'Выберите категорию' }}
    .options(v-if="showOptions")
      .option(
        v-for="value in values"
        :key="value.value"
        :class="(selectedValue !== null && selectedValue.value === value.value) ? 'active' : ''"
        v-on:click="selectValue(value)"
      ) {{ value.title }}

</template>

<script>
  export default {
    name: 'categorySelect',
    data: function () {
      return {
        selectedValue: null,
        showOptions: false,
        values: [
          {
            value: 1,
            title: 'Категория 1',
          },
          {
            value: 2,
            title: 'Категория 2',
          },
          {
            value: 3,
            title: 'Категория 3',
          },
          {
            value: 4,
            title: 'Категория 4',
          },
          {
            value: 5,
            title: 'Категория 5',
          },
          {
            value: 6,
            title: 'Категория 6',
          },
          {
            value: 7,
            title: 'Категория 7',
          },
          {
            value: 8,
            title: 'Категория 8',
          },
          {
            value: 9,
            title: 'Категория 9',
          },
        ]
      };
    },
    methods: {
      selectValue: function (value) {
        this.selectedValue = (this.selectedValue !== null && this.selectedValue.value === value.value) ? null : value;
        this.showOptions = false;
      },
      toggleOptions: function () {
        this.showOptions = !this.showOptions;
      }
    },
  }
</script>

<style lang="scss">
  .options {
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    margin-top: 10px;
    max-height: 150px;
    overflow-y: scroll;

    .option {
      padding: 10px;
      cursor: pointer;

      &:hover {
        color: rgb(83, 136, 186);
      }
    }

    .active {
      color: rgb(83, 136, 186);
    }

    &::-webkit-scrollbar {
      background-color: rgb(235, 243, 249);
    }

    &::-webkit-scrollbar-thumb {
      background-color: rgb(245, 86, 46);
    }
  }
</style>
