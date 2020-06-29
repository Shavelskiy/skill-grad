import { SET_PROVIDER_LIST, SET_LOCATIONS } from './types'


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
