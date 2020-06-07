import { NUMBER, STRING } from '../../components/table-search/types'
import { TAG_VIEW } from '../../utils/routes'

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
    title: 'Сортировка',
    name: 'sort',
    search: {
      enable: true,
      type: NUMBER,
    },
  }
]

export const actions = [
  {
    type: 'view',
    link: TAG_VIEW,
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
