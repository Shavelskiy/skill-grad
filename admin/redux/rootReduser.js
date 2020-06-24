import {
  HIDE_LOADER,
  SHOW_LOADER,
  SET_TITLE,
  SET_BREADCRUMBS,
  SET_CURRENT_USER,
  SET_REDIRECT_LINK, SHOW_ALERT
} from './types'

const rootBreadcrumb = {
  title: 'Главная',
  link: '/',
}

const initialState = {
  loading: 0,
  alertMessage: null,
  title: 'Skill Grad Admin',
  breadcrumbs: [rootBreadcrumb],
  currentUser: null,
  redirectLink: null,
}

export const rootReducer = (state = initialState, action) => {
  switch (action.type) {
    case SHOW_LOADER:
      return {...state, loading: state.loading + 1}
    case HIDE_LOADER:
      return {...state, loading: state.loading - 1}
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
    case SET_REDIRECT_LINK:
      return {...state, redirectLink: action.payload}
    case SHOW_ALERT:
      return {...state, alertMessage: action.payload}
    default:
      return state
  }
}
