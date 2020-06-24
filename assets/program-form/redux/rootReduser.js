import {
  SHOW_LOADER,
} from './types'

const initialState = {
  loading: 0,
}

export const rootReducer = (state = initialState, action) => {
  switch (action.type) {
    case SHOW_LOADER:
      return {...state, loading: state.loading + 1}
    default:
      return state
  }
}
