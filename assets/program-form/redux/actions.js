import {
  SET_NAME,
  SET_CATEGORY,
  SET_ANNOTATION,
  SET_DETAIL_TEXT,
} from './types'

export function setName(name) {
  return {
    type: SET_NAME,
    payload: name,
  }
}

export function setCategory(key, value) {
  return {
    type: SET_CATEGORY,
    payload: {
      key: key,
      value: value,
    },
  }
}

export function setAnnotation(annotation) {
  return {
    type: SET_ANNOTATION,
    payload: annotation,
  }
}

export function setDetailText(detailText) {
  return {
    type: SET_DETAIL_TEXT,
    payload: detailText,
  }
}