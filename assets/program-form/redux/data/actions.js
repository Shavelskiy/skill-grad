import { SET_PROVIDER_LIST, SET_LOCATIONS, SET_FIELDS } from './types'
import { SET_CURRENT_USER } from '../../../../admin/redux/types'


export function setFields(fields) {
  return {
    type: SET_FIELDS,
    payload: fields,
  }
}

export function setCurrentProvider(data) {
  return {
    type: SET_CURRENT_USER,
    payload: data,
  }
}

export function setProviderList(providers) {
  return {
    type: SET_PROVIDER_LIST,
    payload: providers,
  }
}

export function setLocations(locations) {
  return {
    type: SET_LOCATIONS,
    payload: locations,
  }
}
