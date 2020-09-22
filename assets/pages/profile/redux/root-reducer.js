import {SET_PROGRAM_TITLE} from './types'

const initialState = {
  programTitle: '',
}

export const rootReducer = (state = initialState, action) => {
  switch (action.type) {
    case SET_PROGRAM_TITLE:
      return {
        ...state,
        programTitle: action.payload,
      }
    default:
      return state
  }
}
