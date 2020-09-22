import {
  SET_NAME,
  SET_CATEGORY,
  SET_ANNOTATION,
  SET_DETAIL_TEXT,
  SET_TEACHERS,
  SELECT_DURATION,
  SELECT_FORMAT,
  SELECT_ADDITIONAL,
  SELECT_KNOWLEDGE_CHECK,
  SET_ADVANTAGES,
  SET_PROCESS_DESCRIPTION,
  SELECT_DESIGN,
  ADD_NEW_PROVIDER,
  DELETE_NEW_PROVIDER,
  UPDATE_NEW_PROVIDER,
  SET_PROVIDERS_FROM_LIST,
  SET_TARGET_AUDIENCE,
  SET_LEVEL,
  SET_PREPARATIONS,
  SET_GAINED_KNOWLEDGE,
  SET_CERTIFICATE,
  SET_TRAINING_DATE,
  SET_OCCUPATION_MODE,
  SET_LOCATION,
  SELECT_INCLUDE,
  SET_PRICE,
  SET_SHOW_PRICE_REDUCTION,
  SET_DISCOUNTS,
  SET_ACTIONS,
  SET_FAVORITE_PROVIDER_ACTION,
  SET_TERM_OF_PAYMENT,
  SET_GALLERY,
  SELECT_LOCATIONS,
  SET_ADDITIONAL_INFO,
} from './types'
import { DESIGN_SIMPLE, DURATION_HOURS } from '../../utils/field-types'


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
  newProviders: [],
  selectedProvidersIds: [],
  targetAudience: [],
  level: null,
  preparations: [],
  gainedKnowledge: '',
  certificate: {
    name: '',
    file: null,
  },
  traningDate: {
    type: null,
    extra: null,
  },
  occupationMode: {
    type: null,
    extra: null,
  },
  location: '',
  include: {
    values: [],
    otherValue: '',
  },
  price: {
    legalEntity: {
      checked: false,
      price: 0,
    },
    individual: {
      checked: false,
      price: 0,
    },
    byRequest: false,
  },
  showPriceReduction: false,
  discounts: {
    legalEntity: {
      checked: false,
      value: 0,
    },
    individual: {
      checked: false,
      value: 0,
    },
    byRequest: false,
  },
  actions: [],
  favoriteProviderAction: {
    firstDiscount: 0,
    nextDiscount: 0,
  },
  termOfPayment: {
    legalEntity: {
      checked: false,
      value: '',
    },
    individual: {
      checked: false,
      value: '',
    },
    byRequest: false,
  },
  gallery: [],
  locations: [],
  additionalInfo: '',
}

export const programReducer = (state = initialState, action) => {
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
    case SET_TEACHERS:
      return {...state, teachers: action.payload}
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
      return {...state, newProviders: [...state.newProviders, action.payload]}
    case UPDATE_NEW_PROVIDER:
      return {
        ...state, newProviders: state.newProviders.map((provider, key) => {
          return key === action.payload.key ? action.payload.provider : provider
        })
      }
    case DELETE_NEW_PROVIDER:
      return {...state, newProviders: state.newProviders.filter((item, key) => key !== action.payload)}
    case SET_PROVIDERS_FROM_LIST:
      return {...state, selectedProvidersIds: action.payload}
    case SET_TARGET_AUDIENCE:
      return {...state, targetAudience: action.payload}
    case SET_LEVEL:
      return {...state, level: action.payload}
    case SET_PREPARATIONS:
      return {...state, preparations: action.payload}
    case SET_GAINED_KNOWLEDGE:
      return {...state, gainedKnowledge: action.payload}
    case SET_CERTIFICATE:
      return {...state, certificate: action.payload}
    case SET_TRAINING_DATE:
      return {...state, traningDate: action.payload}
    case SET_OCCUPATION_MODE:
      return {...state, occupationMode: action.payload}
    case SET_LOCATION:
      return {...state, location: action.payload}
    case SELECT_INCLUDE:
      return {...state, include: action.payload}
    case SET_PRICE:
      return {...state, price: action.payload}
    case SET_SHOW_PRICE_REDUCTION:
      return {...state, showPriceReduction: action.payload}
    case SET_DISCOUNTS:
      return {...state, discounts: action.payload}
    case SET_ACTIONS:
      return {...state, actions: action.payload}
    case SET_FAVORITE_PROVIDER_ACTION:
      return {...state, favoriteProviderAction: action.payload}
    case SET_TERM_OF_PAYMENT:
      return {...state, termOfPayment: action.payload}
    case SET_GALLERY:
      return {...state, gallery: action.payload}
    case SELECT_LOCATIONS:
      return {...state, locations: action.payload}
    case SET_ADDITIONAL_INFO:
      return {...state, additionalInfo: action.payload}
    default:
      return state
  }
}
