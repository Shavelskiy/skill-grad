import {
  CATEGORY_INDEX,
  LOCATION_INDEX,
  ARTICLE_INDEX,
  USER_INDEX,
  PROGRAM_FORMAT_INDEX,
  PROVIDER_INDEX,
  PROGRAM_INCLUDE_INDEX,
  PROGRAM_ADDITIONAL_INDEX,
  PROGRAM_LEVEL_INDEX,
  FEEDBACK_INDEX,
  PRICES_INDEX,
  FAQ_INDEX,
  PAGE_INDEX,
} from '../../utils/routes'

export const menuItems = [
  {
    title: 'Программы обучения',
    icon: 'fa fa-university',
    items: [
      {
        title: 'Категории',
        link: CATEGORY_INDEX,
      },
      {
        title: 'Формы обучения',
        link: PROGRAM_FORMAT_INDEX,
      },
      {
        title: 'Дополнительные пункты',
        link: PROGRAM_ADDITIONAL_INDEX,
      },
      {
        title: 'Включено в курс',
        link: PROGRAM_INCLUDE_INDEX,
      },
      {
        title: 'Уровни',
        link: PROGRAM_LEVEL_INDEX,
      },
    ],
  },
  {
    title: 'Провайдеры обучения',
    icon: 'fa fa-chalkboard-teacher',
    items: [
      {
        title: 'Список провайдеров',
        link: PROVIDER_INDEX,
      }
    ],
  },
  {
    title: 'Блог',
    icon: 'fa fa-rss-square',
    items: [
      {
        title: 'Статьи',
        link: ARTICLE_INDEX,
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
  {
    title: 'Форма обратной связи',
    icon: 'fa fa-comments',
    items: [
      {
        title: 'Список вопросов',
        link: FEEDBACK_INDEX,
      },
    ],
  },
  {
    title: 'Платные услуги',
    icon: 'fa fa-ruble-sign',
    items: [
      {
        title: 'Цены на платные услуги',
        link: PRICES_INDEX,
      },
    ],
  },
  {
    title: 'Контент',
    icon: 'fa fa-sticky-note',
    items: [
      {
        title: 'FAQ',
        link: FAQ_INDEX,
      },
      {
        title: 'Отдельные страницы',
        link: PAGE_INDEX,
      },
    ],
  },
]
