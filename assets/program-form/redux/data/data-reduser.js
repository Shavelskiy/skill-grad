import { SET_LOCATIONS } from './types'


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
  locations: [],
}

export const dataReduser = (state = initialState, action) => {
  switch (action.type) {
    case SET_LOCATIONS:
      return {...state, locations: action.payload}
    default:
      return state
  }
}
