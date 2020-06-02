import { LOCATION_INDEX, TAG_INDEX, USER_INDEX } from '../../utils/routes'

export const menuItems = [
  {
    title: 'Блог',
    icon: 'fa fa-rss-square',
    items: [
      {
        title: 'Статьи',
        link: '/article',
      },
      {
        title: 'Теги',
        link: TAG_INDEX,
      },
      {
        title: 'Рубрики',
        link: '/rubric',
      },
    ],
  },
  {
    title: 'Настройки пользователей',
    icon: 'fa fa-users',
    items: [
      {
        title: 'Все пользователи',
        link: USER_INDEX,
      },
    ],
  },
  {
    title: 'Настройки местоположений',
    icon: 'fa fa-globe',
    items: [
      {
        title: 'Список всех местоположений',
        link: LOCATION_INDEX,
      },
    ],
  },
]
