import {
  FOCUS_DESCRIPTION,
  FOCUS_DESIGN,
  FOCUS_PROVIDERS,
  FOCUS_LISTENERS,
  FOCUS_RESULT,
  FOCUS_ORGANIZATION,
  FOCUS_TERM_OF_USE,
  FOCUS_GALLERY,
  FOCUS_LOCATIONS,
  FOCUS_ADDITIONAL_INFO
} from './types'

import {RESET_FORM} from './../program/types'

const initialState = {
  description: {
    focus: false,
    active: false,
  },
  design: {
    focus: false,
    active: false,
  },
  providers: {
    focus: false,
    active: false,
  },
  listeners: {
    focus: false,
    active: false,
  },
  result: {
    focus: false,
    active: false,
  },
  organization: {
    focus: false,
    active: false,
  },
  termOfUse: {
    focus: false,
    active: false,
  },
  gallery: {
    focus: false,
    active: false,
  },
  locations: {
    focus: false,
    active: false,
  },
  additionalInfo: {
    focus: false,
    active: false,
  }
}

export const validationReducer = (state = initialState, action) => {
  switch (action.type) {
    case FOCUS_DESCRIPTION:
    case FOCUS_DESIGN:
    case FOCUS_PROVIDERS:
    case FOCUS_LISTENERS:
    case FOCUS_RESULT:
    case FOCUS_ORGANIZATION:
    case FOCUS_TERM_OF_USE:
    case FOCUS_GALLERY:
    case FOCUS_LOCATIONS:
    case FOCUS_ADDITIONAL_INFO:
      return {
        description: {
          focus: action.type === FOCUS_DESCRIPTION,
          active: state.description.active || (state.description.focus && action.type !== FOCUS_DESCRIPTION),
        },
        design: {
          focus: action.type === FOCUS_DESIGN,
          active: state.design.active || (state.design.focus && action.type !== FOCUS_DESIGN),
        },
        providers: {
          focus: action.type === FOCUS_PROVIDERS,
          active: state.providers.active || (state.providers.focus && action.type !== FOCUS_PROVIDERS),
        },
        listeners: {
          focus: action.type === FOCUS_LISTENERS,
          active: state.listeners.active || (state.listeners.focus && action.type !== FOCUS_LISTENERS),
        },
        result: {
          focus: action.type === FOCUS_RESULT,
          active: state.result.active || (state.result.focus && action.type !== FOCUS_RESULT),
        },
        organization: {
          focus: action.type === FOCUS_ORGANIZATION,
          active: state.organization.active || (state.organization.focus && action.type !== FOCUS_ORGANIZATION),
        },
        termOfUse: {
          focus: action.type === FOCUS_TERM_OF_USE,
          active: state.termOfUse.active || (state.termOfUse.focus && action.type !== FOCUS_TERM_OF_USE),
        },
        gallery: {
          focus: action.type === FOCUS_GALLERY,
          active: state.gallery.active || (state.gallery.focus && action.type !== FOCUS_GALLERY),
        },
        locations: {
          focus: action.type === FOCUS_LOCATIONS,
          active: state.locations.active || (state.locations.focus && action.type !== FOCUS_LOCATIONS),
        },
        additionalInfo: {
          focus: action.type === FOCUS_ADDITIONAL_INFO,
          active: state.additionalInfo.active || (state.additionalInfo.focus && action.type !== FOCUS_ADDITIONAL_INFO),
        }
      }
    case RESET_FORM:
      return initialState
    default:
      return state
  }
}
