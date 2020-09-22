import { SET_PROGRAM_TITLE } from './types'


export function setProgramTitle(title) {
  return {
    type: SET_PROGRAM_TITLE,
    payload: title,
  }
}
