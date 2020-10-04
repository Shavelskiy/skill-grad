import {SET_PROGRAM_TITLE, SET_PROGRAM_PRICES, SET_PROVIDER_BALANCE} from './types'
import {HIGHLIGHT, RAISE, HIGHLIGHT_RAISE} from '@/utils/profile/porgram-service-types'

const initialState = {
  programTitle: '',
  programPrices: {
    [HIGHLIGHT]: 0,
    [RAISE]: 0,
    [HIGHLIGHT_RAISE]: 0,
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
