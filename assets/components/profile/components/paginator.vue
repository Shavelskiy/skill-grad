<template lang="pug">
  div(:class="`paginator ${(disabledTable) ? 'disabled' : ''}`")
    request-item(
      v-for="item in items"
      :is="itemComponent"
      :key="item.id"
      :program="item"
    )

    .paginator-pages(v-if="paginator")
      div(
        v-on:click="changeCurrentPage(currentPage - 1)"
        :class="`arrow ${(currentPage > 1) ? 'active' : ''}`"
      )
        img(src="./../images/left-arrow.svg")
      div(
        v-for="page in paginator"
        v-on:click="changeCurrentPage(page)"
        :key="page.id"
        :class="`paginator-pages-item ${(page === currentPage) ? 'active' : ''}`"
      )
        span {{ page }}
      .paginator-pages-item.next(v-if="(totalPages > 4) && ((totalPages - currentPage) > 1)")
        span ...
      div(
        v-on:click="changeCurrentPage(currentPage + 1)"
        :class="`arrow ${(currentPage < totalPages) ? 'active' : ''}`"
      )
        img(src="./../images/right-arrow.svg")
</template>

<script>
  import axios from 'axios';

  export default {
    name: 'paginator',
    props: ['itemComponent', 'additionalParams', 'endpoint'],
    data: function () {
      return {
        totalPages: 1,
        currentPage: 1,
        paginatorRequest: null,
        disabledTable: false,
        items: [],
      };
    },
    methods: {
      changeCurrentPage(page) {
        if (page < 1 || page > this.totalPages || page === this.currentPage) {
          return;
        }

        this.currentPage = page;
        this.loadItems();
      },
      loadItems: function () {
        this.disabledTable = true;
        if (this.paginatorRequest) {
          this.paginatorRequest.cancel();
        }

        const axiosSource = axios.CancelToken.source();
        this.paginatorRequest = {cancel: axiosSource.cancel};

        const params = {
          page: this.currentPage,
        };

        axios.get(this.endpoint, {
          cancelToken: axiosSource.token,
          params: {...params, ...this.additionalParams},
        })
          .then(response => {
            this.currentPage = response.data.currentPage;
            this.totalPages = response.data.totalPages;
            this.items = response.data.items;
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
      this.loadItems();
    },
  }
</script>
