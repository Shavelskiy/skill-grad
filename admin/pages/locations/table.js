import { BOOL, LIST, NUMBER, STRING } from './../../components/table-search/types'
import { BOOLEAN } from '../../utils/table-item-display'
import { ACTION_DELETE, ACTION_UPDATE, ACTION_VIEW } from '../../utils/table-actions'
import { LOCATION_UPDATE, LOCATION_VIEW } from '../../utils/routes'
import { DELETE_LOCATION_URL } from '../../utils/api/endpoints'

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
    title: 'Код',
    name: 'code',
    width: 1,
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
    title: 'Показывать в списке',
    name: 'show_in_list',
    width: 1,
    display: BOOLEAN,
    search: {
      enable: true,
      type: BOOL,
    },
  },
  {
    title: 'Тип',
    name: 'type',
    width: 1,
    search: {
      enable: true,
      type: LIST,
      enum: [
        {
          title: 'Не выбрано',
          value: null,
        },
        {
          title: 'Страна',
          value: 'country',
        },
        {
          title: 'Регион',
          value: 'region',
        },
        {
          title: 'Город',
          value: 'city',
        },
      ]
    },
  },
]

export const actions = [
  {
    type: ACTION_VIEW,
    link: LOCATION_VIEW,
  },
  {
    type: ACTION_UPDATE,
    link: LOCATION_UPDATE,
  },
  {
    type: ACTION_DELETE,
    link: DELETE_LOCATION_URL,
  }
]
