import {
  SET_NAME,
  SET_CATEGORY,
  SET_ANNOTATION,
  SET_DETAIL_TEXT,
  ADD_TEACHER, DELETE_TEACHER, SET_TEACHER_NAME, SET_TEACHER_IMAGE, DELETE_TEACHER_IMAGE, SELECT_DURATION,
} from './types'
import { DURATION_HOURS } from '../utils/field-types'


const initialState = {
  name: '',
  categories: [null, null, null],
  annotation: '',
  detailText: '',
  teachers: [],
  duration: {
    type: DURATION_HOURS,
    value: 0,
  }
}

export const rootReducer = (state = initialState, action) => {
  switch (action.type) {
    case SET_NAME:
      return {...state, name: action.payload}
    case SET_CATEGORY:
      let categories = state.categories
      categories[action.payload.key] = action.payload.value
      return {...state, categories: categories}
    case SET_ANNOTATION:
      return {...state, annotation: action.payload}
    case SET_DETAIL_TEXT:
      return {...state, detailText: action.payload}
    case ADD_TEACHER:
      return {...state, teachers: [...state.teachers, {image: null, name: ''}]}
    case DELETE_TEACHER:
      return {...state, teachers: state.teachers.filter((item, key) => key !== action.payload)}
    case SET_TEACHER_NAME:
      return {
        ...state, teachers: state.teachers.map((teacher, key) => {
          return key === action.payload.key ? {image: teacher.image, name: action.payload.name} : teacher
        })
      }
    case SET_TEACHER_IMAGE:
      return {
        ...state, teachers: state.teachers.map((teacher, key) => {
          return key === action.payload.key ? {image: action.payload.image, name: teacher.name} : teacher
        })
      }
    case DELETE_TEACHER_IMAGE:
      return {
        ...state, teachers: state.teachers.map((teacher, key) => {
          return key === action.payload.key ? {image: null, name: teacher.name} : teacher
        })
      }
    case SELECT_DURATION:
      return {...state, duration: {type: action.payload.type, value: action.payload.value}}
    default:
      return state
  }
}
