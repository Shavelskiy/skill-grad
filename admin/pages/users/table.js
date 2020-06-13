import { BOOL, NUMBER, STRING } from '../../components/table-search/types'
import { BOOLEAN } from '../../utils/table-item-display'

export const table = [
  {
    title: 'Id',
    name: 'id',
    width: 1,
    search: {
      enable: true,
      type: NUMBER,
    },
  },
  {
    title: 'Полное имя',
    name: 'fullName',
    width: 1,
    search: {
      enable: true,
      type: STRING,
    },
  },
  {
    title: 'Почта',
    name: 'email',
    width: 1,
    search: {
      enable: true,
      type: STRING,
    },
  },
  {
    title: 'Телефон',
    name: 'phone',
    width: 1,
    search: {
      enable: true,
      type: NUMBER,
    },
  },
  {
    title: 'Активность',
    name: 'active',
    width: 1,
    display: BOOLEAN,
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
