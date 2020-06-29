import {

} from './types'
import { SET_LOCATIONS } from './types'


const initialState = {
  loaded: 0,
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
