<template lang="pug">
  .programs
    .programs-menu
      .programs-menu-tabs
        div(
          v-on:click="setTabsActive(true)"
          :class="`programs-menu-tab ${(showActive) ? 'programs-menu-tab-active' : ''}`"
        )
          span Активные
        div(
          v-on:click="setTabsActive(false)"
          :class="`programs-menu-tab ${(showActive) ? '' : 'programs-menu-tab-active'}`"
        )
          span Неактивные
      div
      .programs-menu-btn
        button.btn.btn-blue Добавить программу обучения
    .programs-table
      .programs-table-header
        span Название программы
        span Категории
        span Заявки
        span Вопросы
        span Ответы
      .programs-table-body
        program-item(
          v-for="program in programs"
          :key="program.id"
        )
    .paginator
      .paginator-arrow
        img(src="./../../images/left-arrow.svg")
      .paginator-item
        span 11
      .paginator-item
        span 12
      .paginator-item
        span 13
      .paginator-item
        span 14
      .paginator-arrow
        img(src="./../../images/right-arrow.svg")
</template>

<script>
  import programItem from './program-item';

export default {
  name: 'programs',
  components: {
    programItem,
  },
  data: function () {
    return {
      showActive: true,
      programs: [
        {
          id: 1,
          active: true,
          name: '',
          categories: [],
          requests: {
            total: 234,
            new: 45,
          },
          questions: {
            total: 433,
            new: 23,
          },
          answers: {
            total: 433,
            new: 54,
          },
        },  
        {
          id: 1,
          active: true,
          name: '',
          categories: [],
          requests: {
            total: 234,
            new: 45,
          },
          questions: {
            total: 433,
            new: 23,
          },
          answers: {
            total: 433,
            new: 54,
          },
        },  
        {
          id: 1,
          active: true,
          name: '',
          categories: [],
          requests: {
            total: 234,
            new: 45,
          },
          questions: {
            total: 433,
            new: 23,
          },
          answers: {
            total: 433,
            new: 54,
          },
        },  
        {
          id: 1,
          active: true,
          name: '',
          categories: [],
          requests: {
            total: 234,
            new: 45,
          },
          questions: {
            total: 433,
            new: 23,
          },
          answers: {
            total: 433,
            new: 54,
          },
        },  
        {
          id: 1,
          active: true,
          name: '',
          categories: [],
          requests: {
            total: 234,
            new: 45,
          },
          questions: {
            total: 433,
            new: 23,
          },
          answers: {
            total: 433,
            new: 54,
          },
        },  
        {
          id: 1,
          active: true,
          name: '',
          categories: [],
          requests: {
            total: 234,
            new: 45,
          },
          questions: {
            total: 433,
            new: 23,
          },
          answers: {
            total: 433,
            new: 54,
          },
        },  
      ],
    };
  },
  methods: {
    setTabsActive: function (active) {
      this.showActive = active;
    }
  }
}
</script>
