import { BOOL, NUMBER, STRING } from './../../components/table-search/types'
import { BOOLEAN } from '../../utils/table-item-display'
import { ACTION_DELETE, ACTION_UPDATE, ACTION_VIEW } from '../../utils/table-actions'
import { FAQ_VIEW, FAQ_UPDATE } from '../../utils/routes'
import { DELETE_FAQ_URL } from '../../utils/api/endpoints'

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
    title: 'Сортировка',
    name: 'sort',
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
    type: ACTION_VIEW,
    link: FAQ_VIEW,
  },
  {
    type: ACTION_UPDATE,
    link: FAQ_UPDATE,
  },
  {
    type: ACTION_DELETE,
    link: DELETE_FAQ_URL,
  }
]
