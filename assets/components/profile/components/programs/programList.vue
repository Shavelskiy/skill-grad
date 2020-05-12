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
    .table
      .table-header.programs
        span Название программы
        span Категории
        span Заявки
        span Вопросы
        span Оценки
      paginator.table-body(
        :itemComponent="paginatorItem"
        :endpoint="endpoint"
        :additionalParams="{active: Number(this.showActive)}"
        :key="paginatorKey"
      )
</template>

<script>
  import {endpoints} from '../../store/endpoints';
  import programItem from './programItem';
  import paginator from "../paginator";

  export default {
    name: 'programList',
    components: {
      programItem,
      paginator,
    },
    data: function () {
      return {
        paginatorItem: programItem,
        paginatorKey: 1,
        showActive: true,
        endpoint: endpoints.GET_PROGRAM_LIST,
      };
    },
    methods: {
      setTabsActive: function (active) {
        this.showActive = active;
        this.paginatorKey++;
      },
    },
  }
</script>
