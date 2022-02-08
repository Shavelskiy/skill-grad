import { NUMBER, STRING } from './../../components/table-search/types'
import { ACTION_DELETE, ACTION_UPDATE, ACTION_VIEW } from '../../utils/table-actions'
import { PAGE_VIEW, PAGE_UPDATE } from '../../utils/routes'
import { DELETE_PAGE_URL } from '../../utils/api/endpoints'

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
    title: 'Заголовок',
    name: 'title',
    width: 1,
    search: {
      enable: true,
      type: STRING,
    },
  },
  {
    title: 'Код',
    name: 'slug',
    width: 1,
    search: {
      enable: true,
      type: STRING,
    },
  },
]

export const actions = [
  {
    type: ACTION_VIEW,
    link: PAGE_VIEW,
  },
  {
    type: ACTION_UPDATE,
    link: PAGE_UPDATE,
  },
  {
    type: ACTION_DELETE,
    link: DELETE_PAGE_URL,
  }
]
