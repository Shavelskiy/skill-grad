import { SET_PROVIDER_LIST, SET_LOCATIONS, SET_FIELDS } from './types'
import { SET_CURRENT_USER } from '../../../../admin/redux/types'

const initialState = {
  categories: [],
  formats: [],
  additional: [],
  currentProvider: null,
  isProAccount: false,
  providerList: [],
  levels: [],
  include: [],
  locations: [],
}

export const dataReduser = (state = initialState, action) => {
  switch (action.type) {
    case SET_FIELDS:
      return {
        ...state,
        categories: action.payload.categories,
        formats: action.payload.formats,
        additional: action.payload.additional,
        levels: action.payload.levels,
        include: action.payload.include,
      }
    case SET_CURRENT_USER:
      return {
        ...state,
        currentProvider: action.payload.currentProvider,
        isProAccount: action.payload.isProAccount,
      }
    case SET_PROVIDER_LIST:
      return {...state, providerList: action.payload}
    case SET_LOCATIONS:
      return {...state, locations: action.payload}
    default:
      return state
  }
}
