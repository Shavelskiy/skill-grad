<template lang="pug">
  .programs
    .programs-menu.programs
      .programs-menu-tabs
        div(
          v-on:click="setTabsActive(true)"
          :class="`programs-menu-tab ${(showActive) ? 'active' : ''}`"
        )
          span Активные
        div(
          v-on:click="setTabsActive(false)"
          :class="`programs-menu-tab ${(showActive) ? '' : 'active'}`"
        )
          span Неактивные
      div
      .programs-menu-btn
        button.btn.btn-blue Добавить программу обучения
    div(:class="`programs-table ${(disabledTable) ? 'disabled' : ''}`")
      .programs-table-header.programs
        span Название программы
        span Категории
        span Заявки
        span Вопросы
        span Оценки
      .programs-table-body
        program-item(
          v-for="program in programs"
          :key="program.id"
          v-bind:program="program"
        )
    .paginator(v-if="paginator")
      div(
        v-on:click="changeCurrentPage(currentPage - 1)"
        :class="`paginator-arrow ${(currentPage > 1) ? 'active' : ''}`"
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
        :class="`paginator-arrow ${(currentPage < totalPages) ? 'active' : ''}`"
      )
        img(src="./../../images/right-arrow.svg")
</template>

<script>
  import {endpoints} from '../../store/endpoints';
  import axios from 'axios';
  import programItem from './programItem';

  export default {
    name: 'programList',
    components: {
      programItem,
    },
    data: function () {
      return {
        showActive: true,
        totalPages: 1,
        currentPage: 1,
        paginatorRequest: null,
        disabledTable: false,
        programs: [],
      };
    },
    methods: {
      setTabsActive: function (active) {
        this.showActive = active;
        this.currentPage = 1;
        this.loadPrograms();
      },
      changeCurrentPage(page) {
        if (page < 1 || page > this.totalPages || page === this.currentPage) {
          return;
        }

        this.currentPage = page;
        this.loadPrograms();
      },
      loadPrograms: function () {
        this.disabledTable = true;
        if (this.paginatorRequest) {
          this.paginatorRequest.cancel();
        }

        const axiosSource = axios.CancelToken.source();
        this.paginatorRequest = {cancel: axiosSource.cancel};

        axios.get(endpoints.GET_PROGRAM_LIST, {
          cancelToken: axiosSource.token,
          params: {
            page: this.currentPage,
            active: Number(this.showActive),
          },
        })
          .then(response => {
            this.currentPage = response.data.currentPage;
            this.totalPages = response.data.totalPages;
            this.programs = response.data.items;
            this.disabledTable = false;
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
