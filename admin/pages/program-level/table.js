import { NUMBER, STRING } from './../../components/table-search/types'
import { PROGRAM_LEVEL_UPDATE } from '../../utils/routes'
import { DELETE_PROGRAM_LEVEL_URL } from '../../utils/api/endpoints'
import { ACTION_DELETE, ACTION_UPDATE } from '../../utils/table-actions'


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
]

export const actions = [
  {
    type: ACTION_UPDATE,
    link: PROGRAM_LEVEL_UPDATE,
  },
  {
    type: ACTION_DELETE,
    link: DELETE_PROGRAM_LEVEL_URL,
  }
]
