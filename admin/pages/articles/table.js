import { BOOL, NUMBER, STRING } from './../../components/table-search/types'
import { ARTICLE_UPDATE, ARTICLE_VIEW } from '../../utils/routes'
import { DELETE_ARTICLE_URL } from '../../utils/api/endpoints'
import { ACTION_DELETE, ACTION_UPDATE, ACTION_VIEW } from '../../utils/table-actions'
import { BOOLEAN, IMAGE } from '../../utils/table-item-display'


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
    width: 2,
    search: {
      enable: true,
      type: STRING,
    },
  },
  {
    title: 'Символьный код',
    name: 'slug',
    width: 2,
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
  {
    title: 'Картинка',
    name: 'image',
    width: 2,
    display: IMAGE,
    search: {
      enable: false,
    },
  },
  {
    title: 'Показывать на главной',
    name: 'show_on_main',
    width: 1.4,
    display: BOOLEAN,
    search: {
      enable: true,
      type: BOOL,
    },
  },
  {
    title: 'Дата создания',
    name: 'created_at',
    width: 1,
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
