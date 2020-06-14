import { BOOL, NUMBER, STRING } from './../../components/table-search/types'
import { CATEGORY_VIEW, PROGRAM_FORMAT_UPDATE } from '../../utils/routes'
import { DELETE_PROGRAM_FORMAT_URL } from '../../utils/api/endpoints'
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
    width: 2,
    search: {
      enable: true,
      type: STRING,
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
    link: PROGRAM_FORMAT_UPDATE,
  },
  {
    type: ACTION_DELETE,
    link: DELETE_PROGRAM_FORMAT_URL,
  }
]
