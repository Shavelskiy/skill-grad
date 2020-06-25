import {
  SET_NAME,
  SET_CATEGORY,
  SET_ANNOTATION,
  SET_DETAIL_TEXT,
  ADD_TEACHER, DELETE_TEACHER, SET_TEACHER_NAME, SET_TEACHER_IMAGE, DELETE_TEACHER_IMAGE,
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

export function addTeacher() {
  return {
    type: ADD_TEACHER,
  }
}

export function deleteTeacher(key) {
  return {
    type: DELETE_TEACHER,
    payload: key
  }
}

export function setTeacherName(key, name) {
  return {
    type: SET_TEACHER_NAME,
    payload: {
      key: key,
      name: name,
    },
  }
}

export function setTeacherImage(key, image) {
  return {
    type: SET_TEACHER_IMAGE,
    payload: {
      key: key,
      image: image,
    },
  }
}

export function deleteTeacherImage(key) {
  return {
    type: DELETE_TEACHER_IMAGE,
    payload: {
      key: key,
    },
  }
}
