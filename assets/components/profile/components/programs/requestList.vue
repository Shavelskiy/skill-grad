<template lang="pug">
  .programs
    .programs-menu.request
      .programs-menu-tabs
        router-link.back-btn(:to="{ name: 'programs' }") Вернуться к программам
        .title(v-if="programName !== null") Заявки к программе "{{ programName }}"
    div(:class="`programs-table ${(disabledTable) ? 'disabled' : ''}`")
      .programs-table-header.requests
        span Дата/время
        span Автор заявки
        span Контакты
        span Комментарий
      .programs-table-body
        request-item(
          v-for="request in requests"
          :key="request.id"
          v-bind:request="request"
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
  import axios from 'axios';
  import requestItem from './requestItem';

  export default {
    name: 'requestList',
    props: ['id'],
    components: {
      requestItem,
    },
    data: function () {
      return {
        totalPages: 1,
        currentPage: 1,
        paginatorRequest: null,
        disabledTable: false,
        programName: null,
        requests: [],
      };
    },
    methods: {
      changeCurrentPage(page) {
        if (page < 1 || page > this.totalPages || page === this.currentPage) {
          return;
        }

        this.currentPage = page;
        this.loadProgramRequests();
      },
      loadProgramRequests: function () {
        this.disabledTable = true;
        if (this.paginatorRequest) {
          this.paginatorRequest.cancel();
        }

        const axiosSource = axios.CancelToken.source();
        this.paginatorRequest = {cancel: axiosSource.cancel};

        axios.get('/api/profile/programs/requests', {
          cancelToken: axiosSource.token,
          params: {
            page: this.currentPage,
            programId: this.id,
          },
        })
            .then(response => {
              this.currentPage = response.data.currentPage;
              this.totalPages = response.data.totalPages;
              this.requests = response.data.items;
              this.programName = response.data.programName;
              this.disabledTable = false;
            });
      }
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
      this.loadProgramRequests();
    },
  }
</script>
