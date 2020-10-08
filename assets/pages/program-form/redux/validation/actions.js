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

export function focusDescription() {
  return {
    type: FOCUS_DESCRIPTION,
  }
}

export function focusDesign() {
  return {
    type: FOCUS_DESIGN,
  }
}

export function focusProviders() {
  return {
    type: FOCUS_PROVIDERS,
  }
}

export function focusListeners() {
  return {
    type: FOCUS_LISTENERS,
  }
}

export function focusResult() {
  return {
    type: FOCUS_RESULT,
  }
}

export function focusOrganization() {
  return {
    type: FOCUS_ORGANIZATION,
  }
}

export function focusTermOfUse() {
  return {
    type: FOCUS_TERM_OF_USE,
  }
}

export function focusGallery() {
  return {
    type: FOCUS_GALLERY,
  }
}

export function focusLocations() {
  return {
    type: FOCUS_LOCATIONS,
  }
}

export function focusAdditional() {
  return {
    type: FOCUS_ADDITIONAL_INFO,
  }
}
