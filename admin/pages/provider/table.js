import { NUMBER, STRING } from './../../components/table-search/types'
import { CATEGORY_VIEW, PROGRAM_FORMAT_UPDATE, PROVIDER_UPDATE, PROVIDER_VIEW } from '../../utils/routes'
import { DELETE_PROGRAM_FORMAT_URL, DELETE_PROVIDER_URL } from '../../utils/api/endpoints'
import { ACTION_DELETE, ACTION_UPDATE, ACTION_VIEW } from '../../utils/table-actions'
import { IMAGE } from '../../utils/table-item-display'


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
    title: 'Картинка',
    name: 'image',
    display: IMAGE,
    width: 2,
    search: {
      enable: false,
    },
  },
]

export const actions = [
  {
    type: ACTION_VIEW,
    link: PROVIDER_VIEW,
  },
  {
    type: ACTION_UPDATE,
    link: PROVIDER_UPDATE,
  },
  {
    type: ACTION_DELETE,
    link: DELETE_PROVIDER_URL,
  }
]
