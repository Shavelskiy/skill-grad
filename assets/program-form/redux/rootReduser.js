import {
  SET_NAME,
  SET_CATEGORY,
  SET_ANNOTATION,
  SET_DETAIL_TEXT,
  ADD_TEACHER,
  DELETE_TEACHER,
  SET_TEACHER_NAME,
  SET_TEACHER_IMAGE,
  DELETE_TEACHER_IMAGE,
  SELECT_DURATION,
  SELECT_FORMAT,
  SELECT_ADDITIONAL,
  SELECT_KNOWLEDGE_CHECK,
  SET_ADVANTAGES,
  SET_PROCESS_DESCRIPTION,
  SELECT_DESIGN,
  ADD_NEW_PROVIDER, DELETE_PROVIDER, UPDATE_NEW_PROVIDER,
} from './types'
import { DESIGN_SIMPLE, DURATION_HOURS } from '../utils/field-types'


const initialState = {
  name: '',
  categories: [null, null, null],
  annotation: '',
  detailText: '',
  teachers: [],
  duration: {
    type: DURATION_HOURS,
    value: 0,
  },
  format: {
    id: 0,
    otherValue: '',
  },
  processDescription: '',
  programDesign: {
    type: DESIGN_SIMPLE,
    value: [0, 0],
  },
  knowledgeCheck: {
    id: 0,
    otherValue: '',
  },
  additional: {
    values: [],
    otherValue: '',
  },
  advantages: '',
  providers: [{name: 'fffff', image: null, link: '', comment: '', type: 'new'}],
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
      return {...state, duration: action.payload}
    case SELECT_FORMAT:
      return {...state, format: action.payload}
    case SET_PROCESS_DESCRIPTION:
      return {...state, processDescription: action.payload}
    case SELECT_DESIGN:
      return {...state, programDesign: action.payload}
    case SELECT_KNOWLEDGE_CHECK:
      return {...state, knowledgeCheck: action.payload}
    case SELECT_ADDITIONAL:
      return {...state, additional: action.payload}
    case SET_ADVANTAGES:
      return {...state, advantages: action.payload}
    case ADD_NEW_PROVIDER:
      return {...state, providers: [...state.providers, action.payload]}
    case UPDATE_NEW_PROVIDER:
      return {
        ...state, providers: state.providers.map((provider, key) => {
        return key === action.payload.key ? action.payload.provider : provider
        })
      }
    case DELETE_PROVIDER:
      return {...state, providers: state.providers.filter((item, key) => key !== action.payload)}
    default:
      return state
  }
}
