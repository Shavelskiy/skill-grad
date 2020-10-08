import {
  DESIGN_SIMPLE,
  DESIGN_WORK, OCCUPATION_MODE_ANYTIME, OCCUPATION_MODE_TIME,
  OTHER,
  TRAINING_DATE_ANYTIME,
  TRAINING_DATE_AS_THE_GROUP_FORM, TRAINING_DATE_CALENDAR, TRAINING_DATE_REQUEST
} from '@/utils/program-form/field-types';


export function validateName(program) {
  return program.name.length > 3;
}

export function validateCategories(program) {
  return program.categories.filter(category => category !== null).length > 0;
}

export function validateAnnotation(program) {
  return program.annotation.length > 0
}

export function validateDetailText(program) {
  return program.detailText.length > 0
}

export function validateTeachers(program) {
  return program.teachers.filter(teacher => teacher.name.length > 0 && teacher.image !== null).length > 0
}

export function validateDuration(program) {
  return (program.duration.type !== OTHER && program.duration.value !== 0) || (program.duration.type === OTHER && program.duration.value.length > 0)
}

export function validateFormat(program) {
  return program.format.id > 0 || (program.format.id === null && program.format.otherValue.length > 0)
}

export function validateProcessDescription(program) {
  return program.processDescription.length > 0
}

export function validateProgramDesign(program) {
  return (
    (program.programDesign.type === DESIGN_SIMPLE && (program.programDesign.value[0] > 0 || program.programDesign.value[1] > 0)) ||
    program.programDesign.type === DESIGN_WORK ||
    (program.programDesign.type === OTHER && program.programDesign.value.length > 0)
  )
}

export function validateKnowledgeCheck(program) {
  return program.knowledgeCheck.id === true || program.knowledgeCheck.id === false || (program.knowledgeCheck.id === null && program.knowledgeCheck.otherValue.length > 0)
}

export function validateAdditional(program) {
  return program.additional.values.filter(value => value !== 0).length > 0 || program.additional.otherValue.length > 0
}

export function validateAdvantages(program) {
  return program.advantages.length > 0
}

export function validateTargetAudience(program) {
  return program.targetAudience.filter(item => item.length > 0).length > 0
}

export function validateLevel(program) {
  return program.level !== null
}

export function validatePreparation(program) {
  return program.preparations.filter(item => item.length > 0).length > 0
}

export function validateGainedKnowledge(program) {
  return program.gainedKnowledge.length > 0
}

export function validateCertificate(program) {
  return program.certificate.name.length > 0 && program.certificate.file !== null
}

export function validateTrainingDate(program) {
  return (
    program.trainingDate.type === TRAINING_DATE_ANYTIME ||
    program.trainingDate.type === TRAINING_DATE_AS_THE_GROUP_FORM ||
    program.trainingDate.type === TRAINING_DATE_REQUEST ||
    (program.trainingDate.type === TRAINING_DATE_CALENDAR && program.trainingDate.extra.length > 0)
  )
}

export function validateOccupationMode(program) {
  return (
    (program.occupationMode.type === OTHER && program.occupationMode.extra.text.length > 0) ||
    (program.occupationMode.type === OCCUPATION_MODE_TIME && (program.occupationMode.extra.selectedDays.length > 0)) ||
    (program.occupationMode.type === OCCUPATION_MODE_ANYTIME)
  )
}

export function validateLocation(program) {
  return program.location.length > 0
}

export function validateInclude(program) {
  return program.include.length > 0 || program.include.otherValue.length > 0
}

export function validatePrice(program) {
  return (
    program.price.byRequest === true ||
    (program.price.legalEntity.checked === true && program.price.legalEntity.price > 0) ||
    (program.price.individual.checked === true && program.price.individual.price > 0)
  )
}

export function validateActions(program) {
  return program.actions.filter(item => item.length > 0).length > 0
}

export function validateTermOfPayment(program) {
  return (
    program.termOfPayment.byRequest === true ||
    (program.termOfPayment.legalEntity.checked === true && program.termOfPayment.legalEntity.value.length > 0) ||
    (program.termOfPayment.individual.checked === true && program.termOfPayment.individual.value.length > 0)
  )
}

export function validateProgramGallery(program) {
  return program.gallery.length > 0
}

export function validateProgramLocations(program) {
  return program.locations.length > 0
}

export function validateProgramAdditionalInfo(program) {
  return program.additionalInfo.length > 0
}
