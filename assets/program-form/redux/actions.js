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
  SELECT_KNOWLEDGE_CHECK,
  SELECT_ADDITIONAL,
  SET_PROCESS_DESCRIPTION,
  SET_ADVANTAGES,
  SELECT_DESIGN,
  ADD_NEW_PROVIDER,
  DELETE_NEW_PROVIDER,
  UPDATE_NEW_PROVIDER,
  SET_PROVIDER_LIST,
  SET_PROVIDERS_FROM_LIST, SET_TARGET_AUDIENCE, SET_LEVEL, SET_PREPARATIONS,
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

export function selectDuration(type, value) {
  return {
    type: SELECT_DURATION,
    payload: {
      type: type,
      value: value,
    },
  }
}

export function selectFormat(id, otherValue) {
  return {
    type: SELECT_FORMAT,
    payload: {
      id: id,
      otherValue: otherValue,
    },
  }
}

export function setProcessDescription(processDescription) {
  return {
    type: SET_PROCESS_DESCRIPTION,
    payload: processDescription,
  }
}

export function selectDesign(type, value) {
  return {
    type: SELECT_DESIGN,
    payload: {
      type: type,
      value: value,
    },
  }
}

export function selectKnowLedgeCheck(id, otherValue) {
  return {
    type: SELECT_KNOWLEDGE_CHECK,
    payload: {
      id: id,
      otherValue: otherValue,
    },
  }
}

export function selectAdditional(values, otherValue) {
  return {
    type: SELECT_ADDITIONAL,
    payload: {
      values: values,
      otherValue: otherValue,
    },
  }
}

export function setAdvantages(advantages) {
  return {
    type: SET_ADVANTAGES,
    payload: advantages,
  }
}

export function addNewProvider(provider) {
  return {
    type: ADD_NEW_PROVIDER,
    payload: {...provider},
  }
}

export function updateNewProvider(provider, key) {
  return {
    type: UPDATE_NEW_PROVIDER,
    payload: {
      provider: provider,
      key: key,
    }
  }
}

export function deleteNewProvider(key) {
  return {
    type: DELETE_NEW_PROVIDER,
    payload: key,
  }
}

export function setProviderList(providers) {
  return {
    type: SET_PROVIDER_LIST,
    payload: providers,
  }
}

export function chooseProvidersFromList(providerIds) {
  return {
    type: SET_PROVIDERS_FROM_LIST,
    payload: providerIds,
  }
}

export function setTargetAudience(targetAudience) {
  return {
    type: SET_TARGET_AUDIENCE,
    payload: targetAudience,
  }
}

export function setLevel(level) {
  return {
    type: SET_LEVEL,
    payload: level,
  }
}

export function setPreparations(preparations) {
  return {
    type: SET_PREPARATIONS,
    payload: preparations,
  }
}