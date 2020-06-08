import { BOOL, NUMBER, STRING } from '../../components/table-search/types'

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
    title: 'Полное имя',
    name: 'fullName',
    search: {
      enable: true,
      type: STRING,
    },
  },
  {
    title: 'Почта',
    name: 'email',
    search: {
      enable: true,
      type: STRING,
    },
  },
  {
    title: 'Телефон',
    name: 'phone',
    search: {
      enable: true,
      type: NUMBER,
    },
  },
  {
    title: 'Активность',
    name: 'active',
    search: {
      enable: true,
      type: BOOL,
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
    link: '/api/admin/tag/',
  }
]
