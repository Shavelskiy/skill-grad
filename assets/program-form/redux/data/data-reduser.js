import { SET_PROVIDER_LIST, SET_LOCATIONS } from './types'


const initialState = {
  loaded: 0,
  categories: [
    {
      title: 'Архитектура',
      value: 1,
    },
    {
      title: 'Дизайн',
      value: 2,
    },
  ],
  formats: [
    {
      id: 1,
      title: 'Вебинар',
    },
    {
      id: 2,
      title: 'Онлайн курс',
    },
    {
      id: 3,
      title: 'Очная форма обучения',
    },
    {
      id: 4,
      title: 'Очно-заочная форма обучения',
    },
    {
      id: 5,
      title: 'Заочная форма обучения',
    },

    {
      id: 6,
      title: 'Смешанная форма обучения',
    },
  ],
  additional: [
    {
      id: 1,
      title: 'Консультационная поддержка после обучения',
    },
    {
      id: 2,
      title: 'Онлайн форум выпускников',
    },
    {
      id: 3,
      title: 'Трудоустройство, практика, стажировка выпускников',
    },
  ],
  currentProvider: {
    name: 'kekek',
    comment: 'kekekek',
    image: '/upload/5ef5d372a30654.53556181-1593168754.png',
    link: 'https://google.com'
  },
  providerList: [],
  levels: [
    {
      value: 1,
      title: 'Начальный',
    },
    {
      value: 2,
      title: 'Средний',
    },
    {
      value: 3,
      title: 'Продвинутый',
    },
  ],
  include: [
    {
      id: 1,
      title: 'Книги',
    },
    {
      id: 2,
      title: 'Методические материалы',
    },
    {
      id: 3,
      title: 'Кофе-брейки',
    },
    {
      id: 4,
      title: 'Обеды',
    },
  ],
  locations: [],
}

export const dataReduser = (state = initialState, action) => {
  switch (action.type) {
    case SET_PROVIDER_LIST:
      return {...state, providerList: action.payload}
    case SET_LOCATIONS:
      return {...state, locations: action.payload}
    default:
      return state
  }
}
