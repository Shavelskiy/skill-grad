import React from 'react'

import {
  ADDITIONAL_INFO,
  DESCRIPTION,
  DESIGN,
  GALLERY,
  LISTENERS, LOCATIONS,
  ORGANIZATION,
  PROVIDERS,
  RESULTS,
  TERM_OF_USE
} from '@/utils/program-form/titles'

import {
  validateName,
  validateCategories,
  validateAnnotation,
  validateDetailText,
  validateTeachers,
  validateDuration,
  validateFormat,
  validateProcessDescription,
  validateProgramDesign,
  validateKnowledgeCheck,
  validateAdditional,
  validateAdvantages,
  validateTargetAudience,
  validateLevel,
  validatePreparation,
  validateGainedKnowledge,
  validateCertificate,
  validateTrainingDate,
  validateOccupationMode,
  validateLocation,
  validateInclude,
  validatePrice,
  validateActions,
  validateTermOfPayment,
  validateProgramGallery,
  validateProgramLocations,
  validateProgramAdditionalInfo,
} from '@/helpers/validate-program-form'

import { useSelector } from 'react-redux'

import css from './progress-bar.scss?module'
import cn from 'classnames'


const ProgressBar = () => {
  const activeBlocks = useSelector((state) => state.validation)
  const program = useSelector(state => state.program)

  const validateDescription = () => {
    if (!activeBlocks.description.active) {
      return null
    }

    if (!validateName(program) || !validateCategories(program) || !validateAnnotation(program) || !validateDuration(program)) {
      return false
    }

    if (validateDetailText(program) && validateTeachers(program)) {
      return true
    }

    return null
  }

  const validateDesign = () => {
    if (!activeBlocks.design.active) {
      return null
    }

    if (!validateFormat(program) || !validateProgramDesign(program) || !validateKnowledgeCheck(program)) {
      return false
    }

    if (validateProcessDescription(program) && validateAdditional(program) && validateAdvantages(program)) {
      return true
    }

    return null
  }

  const validateProviders = () => {
    if (!activeBlocks.providers.active) {
      return null
    }

    return true
  }

  const validateListeners = () => {
    if (!activeBlocks.listeners.active) {
      return null
    }

    if (!validateLevel(program)) {
      return false
    }

    if (validateTargetAudience(program) && validatePreparation(program)) {
      return true
    }

    return null
  }

  const validateResults = () => {
    if (!activeBlocks.result.active) {
      return null
    }

    if (validateGainedKnowledge(program) && validateCertificate(program)) {
      return true
    }

    return null
  }

  const validateOrganization = () => {
    if (!activeBlocks.organization.active) {
      return null
    }

    if (!validateTrainingDate(program) || !validateOccupationMode(program)) {
      return false
    }

    if (validateLocation(program) && validateInclude(program)) {
      return true
    }

    return null
  }

  const validateTermOfUse = () => {
    if (!activeBlocks.termOfUse.active) {
      return null
    }

    if (!validatePrice(program)) {
      return false
    }

    if (validateActions(program) && validateTermOfPayment(program)) {
      return true
    }

    return null
  }

  const validateGallery = () => {
    if (!activeBlocks.gallery.active) {
      return null
    }

    return validateProgramGallery(program) ? true : null
  }

  const validateLocations = () => {
    if (!activeBlocks.locations.active) {
      return null
    }

    return validateProgramLocations(program)
  }

  const validateAdditionalInfo = () => {
    if (!activeBlocks.additionalInfo.active) {
      return null
    }

    return validateProgramAdditionalInfo(program) ? true : null
  }

  const getProgressPercent = () => {
    let result = 0

    if (validateName(program)) {
      result += 3
    }

    if (validateCategories(program)) {
      result += 4
    }

    if (validateAnnotation(program)) {
      result += 4
    }

    if (validateDetailText(program)) {
      result += 3
    }

    if (validateTeachers(program)) {
      result += 4
    }

    if (validateDuration(program)) {
      result += 4
    }

    if (validateFormat(program)) {
      result += 4
    }

    if (validateProcessDescription(program)) {
      result += 3
    }

    if (validateProgramDesign(program)) {
      result += 4
    }

    if (validateKnowledgeCheck(program)) {
      result += 4
    }

    if (validateAdditional(program)) {
      result += 4
    }

    if (validateAdvantages(program)) {
      result += 3
    }

    if (validateTargetAudience(program)) {
      result += 4
    }

    if (validateLevel(program)) {
      result += 3
    }

    if (validatePreparation(program)) {
      result += 4
    }

    if (validateGainedKnowledge(program)) {
      result += 3
    }

    if (validateCertificate(program)) {
      result += 4
    }

    if (validateTrainingDate(program)) {
      result += 4
    }

    if (validateOccupationMode(program)) {
      result += 4
    }

    if (validateLocation(program)) {
      result += 3
    }

    if (validateInclude(program)) {
      result += 4
    }

    if (validatePrice(program)) {
      result += 4
    }

    if (validateActions(program)) {
      result += 4
    }

    if (validateTermOfPayment(program)) {
      result += 4
    }

    if (validateProgramGallery(program)) {
      result += 4
    }

    if (validateProgramLocations(program)) {
      result += 4
    }

    if (validateProgramAdditionalInfo(program)) {
      result += 3
    }

    return result;
  }

  return (
    <>
      <div className={css.progressBar}>
        <div className={cn(css.item, {
          [css.success]: validateDescription() === true,
          [css.error]: validateDescription() === false,
        })}>
          <span className={css.number}>01</span>
          <span className={css.text}>
           {DESCRIPTION}
        </span>
        </div>
        <div
          className={cn(css.item, {
            [css.success]: validateDesign() === true,
            [css.error]: validateDesign() === false,
          })}>
          <span className={css.number}>02</span>
          <span className={css.text}>
           {DESIGN}
        </span>
        </div>
        <div className={cn(css.item, {
          [css.success]: validateProviders() === true,
          [css.error]: validateProviders() === false,
        })}>
          <span className={css.number}>03</span>
          <span className={css.text}>
           {PROVIDERS}
        </span>
        </div>
        <div className={cn(css.item, {
          [css.success]: validateListeners() === true,
          [css.error]: validateListeners() === false,
        })}>
          <span className={css.number}>04</span>
          <span className={css.text}>
           {LISTENERS}
        </span>
        </div>
        <div className={cn(css.item, {
          [css.success]: validateResults() === true,
          [css.error]: validateResults() === false,
        })}>
          <span className={css.number}>05</span>
          <span className={css.text}>
           {RESULTS}
        </span>
        </div>
        <div className={cn(css.item, {
          [css.success]: validateOrganization() === true,
          [css.error]: validateOrganization() === false,
        })}>
          <span className={css.number}>06</span>
          <span className={css.text}>
           {ORGANIZATION}
        </span>
        </div>
        <div className={cn(css.item, {
          [css.success]: validateTermOfUse() === true,
          [css.error]: validateTermOfUse() === false,
        })}>
          <span className={css.number}>07</span>
          <span className={css.text}>
           {TERM_OF_USE}
        </span>
        </div>
        <div className={cn(css.item, {
          [css.success]: validateGallery() === true,
          [css.error]: validateGallery() === false,
        })}>
          <span className={css.number}>08</span>
          <span className={css.text}>
           {GALLERY}
        </span>
        </div>
        <div className={cn(css.item, {
          [css.success]: validateLocations() === true,
          [css.error]: validateLocations() === false,
        })}>
          <span className={css.number}>09</span>
          <span className={css.text}>
           {LOCATIONS}
        </span>
        </div>
        <div
          className={cn(css.item, {
            [css.success]: validateAdditionalInfo() === true,
            [css.error]: validateAdditionalInfo() === false,
          })}>
          <span className={css.number}>10</span>
          <span className={css.text}>
           {ADDITIONAL_INFO}
        </span>
        </div>
      </div>
      <div className={css.result}>
        Качество описания программы
        <div className={css.tooltip}>
          Чем выше качество описания программы, тем больше шансов, что именно вашу программу выберут и она в большей
          степени будет соответствовать ожиданиям обучающегося и тем она выше
          в результатах выдачи
        </div>
        <div className={css.percents}>
          <span>{getProgressPercent()}%</span>
        </div>
      </div>
    </>
  )
}

export default ProgressBar
