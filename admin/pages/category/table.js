import { BOOL, NUMBER, STRING } from './../../components/table-search/types'
import { CATEGORY_UPDATE, CATEGORY_VIEW } from '../../utils/routes'
import { DELETE_CATEGORY_URL } from '../../utils/api/endpoints'
import { ACTION_DELETE, ACTION_UPDATE, ACTION_VIEW } from '../../utils/table-actions'
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
    title: 'Название',
    name: 'name',
    width: 1,
    search: {
      enable: true,
      type: STRING,
    },
  },
  {
    title: 'Символьный код',
    name: 'slug',
    width: 1,
    search: {
      enable: true,
      type: STRING,
    },
  },
  {
    title: 'Является родительской категорией',
    name: 'is_parent',
    width: 1,
    display: BOOLEAN,
    search: {
      enable: true,
      type: BOOL,
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
    link: DELETE_CATEGORY_URL,
  }
]
