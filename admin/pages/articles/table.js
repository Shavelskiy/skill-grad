import { NUMBER, STRING } from './../../components/table-search/types'
import { ARTICLE_UPDATE, ARTICLE_VIEW } from '../../utils/routes'
import { DELETE_ARTICLE_URL } from '../../utils/api/endpoints'
import { ACTION_DELETE, ACTION_UPDATE, ACTION_VIEW } from '../../utils/table-actions'
import { IMAGE } from '../../utils/table-item-display'


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
    title: 'Символьный код',
    name: 'slug',
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
  },
  {
    title: 'Картинка',
    name: 'image',
    display: IMAGE,
    search: {
      enable: false,
    },
  },
]

export const actions = [
  {
    type: ACTION_VIEW,
    link: ARTICLE_VIEW,
  },
  {
    type: ACTION_UPDATE,
    link: ARTICLE_UPDATE,
  },
  {
    type: ACTION_DELETE,
    link: DELETE_ARTICLE_URL,
  }
]
