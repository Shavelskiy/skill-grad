import {
  SET_PROGRAM_TITLE,
  SET_PROGRAM_PRICES,
  SET_PROVIDER_BALANCE,
  SET_PRO_ACCOUNT_PRICE,
  SET_PRO_ACCOUNT
} from './types'


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

export function setProAccountPrice(price) {
  return {
    type: SET_PRO_ACCOUNT_PRICE,
    payload: price,
  }
}

export function setProviderBalance(balance) {
  return {
    type: SET_PROVIDER_BALANCE,
    payload: balance,
  }
}

export function setProAccount(isProAccount) {
  return {
    type: SET_PRO_ACCOUNT,
    payload: isProAccount,
  }
}
