import { NUMBER, STRING } from './../../components/table-search/types'
import { FEEDBACK_VIEW } from '../../utils/routes'
import { DELETE_FEEDBACK_ITEM_URL } from '../../utils/api/endpoints'
import { ACTION_DELETE, ACTION_VIEW } from '../../utils/table-actions'
import { DATETIME } from '../../utils/table-item-display'


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
    title: 'Автор',
    name: 'author_name',
    width: 2,
    search: {
      enable: true,
      type: STRING,
    },
  },
  {
    title: 'Email',
    name: 'email',
    width: 1,
    search: {
      enable: true,
      type: STRING,
    },
  },
  {
    title: 'Дата создания',
    name: 'created_at',
    width: 1,
    display: DATETIME,
    search: {
      enable: false,
    },
  },
  {
    title: 'Вопрос',
    name: 'text',
    width: 4,
    display: STRING,
    search: {
      enable: true,
      type: STRING,
    },
  },
]

export const actions = [
  {
    type: ACTION_VIEW,
    link: FEEDBACK_VIEW,
  },
  {
    type: ACTION_DELETE,
    link: DELETE_FEEDBACK_ITEM_URL,
  }
]
