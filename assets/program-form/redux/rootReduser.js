import {
  SET_NAME,
  SET_CATEGORY,
  SET_ANNOTATION,
  SET_DETAIL_TEXT,
} from './types'

const initialState = {
  name: '',
  categories: [null, null, null],
  annotation: '',
  detailText: '',
}

export const rootReducer = (state = initialState, action) => {
  switch (action.type) {
    case SET_NAME:
      return {...state, name: action.payload}
    case SET_CATEGORY:
      let categories = state.categories
      categories[ action.payload.key] = action.payload.value
      return {...state, categories: categories}
    case SET_ANNOTATION:
      return {...state, annotation: action.payload}
    case SET_DETAIL_TEXT:
      return {...state, detailText: action.payload}
    default:
      return state
  }
}
