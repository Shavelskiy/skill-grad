import { BOOL, NUMBER, STRING } from './../../components/table-search/types'
import { PROGRAM_ADDITIONAL_UPDATE } from '../../utils/routes'
import { DELETE_PROGRAM_ADDITIONAL_URL } from '../../utils/api/endpoints'
import { ACTION_DELETE, ACTION_UPDATE } from '../../utils/table-actions'
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
]

export const actions = [
  {
    type: ACTION_UPDATE,
    link: PROGRAM_ADDITIONAL_UPDATE,
  },
  {
    type: ACTION_DELETE,
    link: DELETE_PROGRAM_ADDITIONAL_URL,
  }
]
