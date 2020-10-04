import {SET_PROGRAM_TITLE, SET_PROGRAM_PRICES, SET_PROVIDER_BALANCE} from './types'

const initialState = {
  programTitle: '',
  programPrices: {
    highlight: 0,
    highlight_raise: 0,
    raise: 0,
  },
  balance: 0.0,
}

export const rootReducer = (state = initialState, action) => {
  switch (action.type) {
    case SET_PROGRAM_TITLE:
      return {
        ...state,
        programTitle: action.payload,
      }
    case SET_PROGRAM_PRICES:
      return {
        ...state,
        programPrices: action.payload,
      }
    case SET_PROVIDER_BALANCE:
      return {
        ...state,
        balance: action.payload,
      }
    default:
      return state
  }
}
