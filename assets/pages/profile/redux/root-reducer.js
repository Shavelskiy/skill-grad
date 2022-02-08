import {
  SET_PROGRAM_TITLE,
  SET_PROGRAM_PRICES,
  SET_PROVIDER_BALANCE,
  SET_PRO_ACCOUNT_PRICE,
  SET_PRO_ACCOUNT
} from './types'
import { HIGHLIGHT, RAISE, HIGHLIGHT_RAISE } from '@/utils/profile/porgram-service-types'

const initialState = {
  programTitle: '',
  programPrices: {
    [HIGHLIGHT]: 0,
    [RAISE]: 0,
    [HIGHLIGHT_RAISE]: 0,
  },
  proAccountPrice: 0,
  balance: 0.0,
  proAccount: false,
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
    case SET_PRO_ACCOUNT_PRICE:
      return {
        ...state,
        proAccountPrice: action.payload,
      }
    case SET_PRO_ACCOUNT:
      return {
        ...state,
        proAccount: action.payload,
      }
    default:
      return state
  }
}
