import { BOOL, NUMBER, STRING } from './../../components/table-search/types'
import { CATEGORY_UPDATE, CATEGORY_VIEW } from '../../utils/routes'
import { CATEGORY_DELETE_URL } from '../../utils/api/endpoints'
import { ACTION_DELETE, ACTION_UPDATE, ACTION_VIEW } from '../../utils/table-actions'


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
    title: 'Является родительской категорией',
    name: 'is_parent',
    search: {
      enable: true,
      type: BOOL,
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
    type: ACTION_VIEW,
    link: CATEGORY_VIEW,
  },
  {
    type: ACTION_UPDATE,
    link: CATEGORY_UPDATE,
  },
  {
    type: ACTION_DELETE,
    link: CATEGORY_DELETE_URL,
  }
]
