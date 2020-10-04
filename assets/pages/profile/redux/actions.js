import {SET_PROGRAM_TITLE, SET_PROGRAM_PRICES, SET_PROVIDER_BALANCE} from './types'


export function setProgramTitle(title) {
  return {
    type: SET_PROGRAM_TITLE,
    payload: title,
  }
}

export function setProgramPrices(prices) {
  return {
    type: SET_PROGRAM_PRICES,
    payload: prices,
  }
}

export function setProviderBalance(balance) {
  return {
    type: SET_PROVIDER_BALANCE,
    payload: balance,
  }
}