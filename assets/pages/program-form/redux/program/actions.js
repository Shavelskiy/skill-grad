import {
  SET_NAME,
  SET_CATEGORY,
  SET_ANNOTATION,
  SET_DETAIL_TEXT,
  SET_TEACHERS,
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
  RESET_FORM, SET_PROGRAM
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

export function setTeachers(teachers) {
  return {
    type: SET_TEACHERS,
    payload: teachers,
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

export function setGainedKnowledge(gainedKnowledge) {
  return {
    type: SET_GAINED_KNOWLEDGE,
    payload: gainedKnowledge
  }
}

export function setCertificate(certificate) {
  return {
    type: SET_CERTIFICATE,
    payload: certificate,
  }
}

export function setTrainingDate(type, extra = null) {
  return {
    type: SET_TRAINING_DATE,
    payload: {
      type: type,
      extra: extra,
    }
  }
}

export function setOccupationMode(type, extra = null) {
  return {
    type: SET_OCCUPATION_MODE,
    payload: {
      type: type,
      extra: extra,
    }
  }
}

export function setLocation(location) {
  return {
    type: SET_LOCATION,
    payload: location
  }
}

export function selectInclude(values, otherValue) {
  return {
    type: SELECT_INCLUDE,
    payload: {
      values: values,
      otherValue: otherValue,
    },
  }
}

export function setPrice(price) {
  return {
    type: SET_PRICE,
    payload: price,
  }
}

export function setShowPriceReduction(showPriceReduction) {
  return {
    type: SET_SHOW_PRICE_REDUCTION,
    payload: showPriceReduction,
  }
}

export function setDiscounts(discounts) {
  return {
    type: SET_DISCOUNTS,
    payload: discounts,
  }
}

export function setActions(actions) {
  return {
    type: SET_ACTIONS,
    payload: actions,
  }
}

export function setFavoriteProviderAction(action) {
  return {
    type: SET_FAVORITE_PROVIDER_ACTION,
    payload: action,
  }
}

export function setTermOfPayment(termOfPayment) {
  return {
    type: SET_TERM_OF_PAYMENT,
    payload: termOfPayment,
  }
}

export function setGallery(gallery) {
  return {
    type: SET_GALLERY,
    payload: gallery,
  }
}

export function selectLocations(locations) {
  return {
    type: SELECT_LOCATIONS,
    payload: locations,
  }
}

export function setAdditionalInfo(additionalInfo) {
  return {
    type: SET_ADDITIONAL_INFO,
    payload: additionalInfo,
  }
}

export function setProgram(program) {
  return {
    type: SET_PROGRAM,
    payload: program,
  }
}

export function resetProgramForm() {
  return {
    type: RESET_FORM,
  }
}
