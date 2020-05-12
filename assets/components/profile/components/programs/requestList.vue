<template lang="pug">
  .programs
    .programs-menu.request
      .programs-menu-tabs
        router-link.back-btn(:to="{ name: 'programs' }") Вернуться к программам
        .title(v-if="programName !== null") Заявки к программе "{{ programName }}"
    .table
      .table-header.requests
        span Дата/время
        span Автор заявки
        span Контакты
        span Комментарий
      paginator.table-body(
        :itemComponent="paginatorItem"
        :endpoint="endpoint"
        :additionalParams="{programId: id}"
        @fillExternalData="fillExternalData"
      )
</template>

<script>
  import {endpoints} from '../../store/endpoints';
  import requestItem from './requestItem';
  import paginator from '../paginator';

  export default {
    name: 'requestList',
    props: ['id'],
    components: {
      requestItem,
      paginator,
    },
    data: function () {
      return {
        paginatorItem: requestItem,
        programName: null,
        showActive: true,
        endpoint: endpoints.GET_PROGRAM_REQUEST_LIST,
      };
    },
    methods: {
      fillExternalData: function (data) {
        this.programName = data.programName;
      }
    },
  }
</script>
