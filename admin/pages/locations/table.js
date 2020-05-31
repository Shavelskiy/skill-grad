import { NUMBER, STRING } from '../../components/table/searchTypes'

export const table = [
  {
    title: 'Id',
    name: 'id',
    search: {
      enable: true,
      type: NUMBER,
    },
  },
  {
    title: 'Название',
    name: 'name',
    search: {
      enable: true,
      type: STRING,
    },
  },
  {
    title: 'Тип',
    name: 'type',
    search: {
      enable: false,
    },
  },
  {
    title: 'Сортировка',
    name: 'sort',
    search: {
      enable: true,
      type: NUMBER,
    },
  },
]

export const actions = [
  {
    type: 'view',
    link: '/tag',
  },
  {
    type: 'update',
    link: '/tag',
  },
  {
    type: 'delete',
    link: '/api/admin/location/',
  }
]
