import { NUMBER, STRING } from './../../components/table-search/types'
import { ACTION_UPDATE } from '../../utils/table-actions'
import { PRICES_UPDATE } from '../../utils/routes'

export const table = [
  {
    title: 'Id',
    name: 'id',
    width: 1,
    search: {
      enable: false,
      type: NUMBER,
    },
  },
  {
    title: 'Название',
    name: 'title',
    width: 1,
    search: {
      enable: false,
      type: STRING,
    },
  },
  {
    title: 'Цена',
    name: 'price',
    width: 1,
    search: {
      enable: false,
      type: NUMBER,
    },
  },
]

export const actions = [
  {
    type: ACTION_UPDATE,
    link: PRICES_UPDATE,
  },
]
