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
          v-bind:program="program"
        )
    .paginator(v-if="paginator")
      div(
        v-on:click="changeCurrentPage(currentPage - 1)" 
        :class="(currentPage > 1) ? 'paginator-arrow active' : 'paginator-arrow'"
      )
        img(src="./../../images/left-arrow.svg")
      div(
        v-for="page in paginator" 
        v-on:click="changeCurrentPage(page)"
        :key="page.id" 
        :class="`paginator-item ${(page === currentPage) ? 'active' : ''}`"
      )
        span {{ page }}
      .paginator-item.next(v-if="(totalPages > 4) && ((totalPages - currentPage) > 1)")
        span ...
      div(
        v-on:click="changeCurrentPage(currentPage + 1)"
        :class="(currentPage < totalPages) ? 'paginator-arrow active' : 'paginator-arrow'"
      )
        img(src="./../../images/right-arrow.svg")
</template>

<script>
  import programItem from './program-item';
  import axios from 'axios';

export default {
  name: 'programs',
  components: {
    programItem,
  },
  data: function () {
    return {
      showActive: true,
      totalPages: 1,
      currentPage: 1,
      programs: [],
    };
  },
  methods: {
    setTabsActive: function (active) {
      this.showActive = active;
    },
    changeCurrentPage(page) {
      if (page < 1 || page > this.totalPages) {
        return;
      }

      this.currentPage = page;
      this.loadPrograms();
    },
    loadPrograms: function () {
      axios.get('/api/profile/programs/', {
        params: {
          page: this.currentPage,
        },        
      }) 
        .then(response => {
          this.currentPage = response.data.currentPage;
          this.totalPages = response.data.totalPages;
          this.programs = response.data.items;
        });
    },
  },
  computed: {
    paginator: function () {
      let result = [];
      let iterator = this.currentPage - ((this.currentPage !== this.totalPages) ? 3 : 4);

      while (result.length < 4 && iterator < this.totalPages) {
        iterator++;

        if (iterator < 1) {
          continue;
        }

        result.push(iterator);
      }

      return result;
    },
  },
  created() {
    this.loadPrograms();
  },
}
  </script>
