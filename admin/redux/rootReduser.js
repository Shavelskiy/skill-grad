import { HIDE_LOADER, SHOW_LOADER, SET_TITLE, SET_BREADCRUMBS, SET_CURRENT_USER, LOAD_APP } from './types'

const rootBreadcrumb = {
  title: 'Главная',
  link: '/',
}

const initialState = {
  loading: false,
  title: 'Skill Grad Admin',
  breadcrumbs: [rootBreadcrumb],
  currentUser: null,
}

export const rootReducer = (state = initialState, action) => {
  switch (action.type) {
    case SHOW_LOADER:
      return {...state, loading: true}
    case HIDE_LOADER:
      return {...state, loading: false}
    case SET_TITLE:
      document.title = action.payload
      return {...state, title: action.payload}
    case SET_BREADCRUMBS:
      if (action.payload.withRoot) {
        return {...state, breadcrumbs: [rootBreadcrumb, ...action.payload.items]}
      } else {
        return {...state, breadcrumbs: action.payload.items}
      }
    case SET_CURRENT_USER:
      return {...state, currentUser: action.payload}
    default:
      return state
  }
}
