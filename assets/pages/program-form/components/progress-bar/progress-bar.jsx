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
  DESIGN_SIMPLE,
  DESIGN_WORK,
  DURATION_HOURS,
  TRAINING_DATE_CALENDAR,
  TRAINING_DATE_ANYTIME,
  TRAINING_DATE_AS_THE_GROUP_FORM,
  TRAINING_DATE_REQUEST,
  OTHER
} from '@/utils/program-form/field-types'

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

    return true
  }

  const validateDesign = () => {
    if (!activeBlocks.design.active) {
      return null
    }

    return true
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

    return true
  }

  const validateResults = () => {
    if (!activeBlocks.result.active) {
      return null
    }

    return true
  }

  const validateOrganization = () => {
    if (!activeBlocks.organization.active) {
      return null
    }

    return true
  }

  const validateTermOfUse = () => {
    if (!activeBlocks.termOfUse.active) {
      return null
    }

    return true
  }

  const validateGallery = () => {
    if (!activeBlocks.gallery.active) {
      return null
    }

    return true
  }

  const validateLocations = () => {
    if (!activeBlocks.locations.active) {
      return null
    }

    return true
  }

  const validateAdditionalInfo = () => {
    if (!activeBlocks.additionalInfo.active) {
      return null
    }

    return true
  }

  const getProgressPercent = () => {
    let result = 0

    if (program.name.length > 3) {
      result += 5
    }

    if (program.categories.filter(category => category !== null).length > 0) {
      result += 5
    }

    if (program.annotation.length > 0) {
      result += 5
    }

    if (program.detailText.length > 0) {
      result += 5
    }

    if (program.teachers.filter(teacher => teacher.name.length > 0 && teacher.image !== null).length > 0) {
      result += 5
    }

    if ((program.duration.type !== OTHER && program.duration.value !== 0) || (program.duration.type === OTHER && program.duration.value.length > 0)) {
      result += 5
    }

    if (program.format.id > 0 || (program.format.id === null && program.format.otherValue.length > 0)) {
      result += 5
    }

    if (program.processDescription.length > 0) {
      result += 5
    }

    if (
      (program.programDesign.type === DESIGN_SIMPLE && (program.programDesign.value[0] > 0 || program.programDesign.value[1] > 0)) ||
      program.programDesign.type === DESIGN_WORK ||
      (program.programDesign.type === OTHER && program.programDesign.value.length > 0)
    ) {
      result += 5
    }

    if (program.knowledgeCheck.id === true || program.knowledgeCheck.id === false || (program.knowledgeCheck.id === null && program.knowledgeCheck.otherValue.length > 0)) {
      result += 5
    }

    if (program.additional.values.filter(value => value !== 0).length > 0 || program.additional.otherValue.length > 0) {
      result += 5
    }

    if (program.advantages.length > 0) {
      result += 5
    }

    if (program.targetAudience.filter(item => item.length > 0).length > 0) {
      result += 5
    }

    if (program.level !== null) {
      result += 5
    }

    if (program.preparations.filter(item => item.length > 0).length > 0) {
      result += 5
    }

    if (program.gainedKnowledge.length > 0) {
      result += 5
    }

    if (program.certificate.name.length > 0 && program.certificate.file !== null) {
      result += 5
    }

    if (
      program.trainingDate.type === TRAINING_DATE_ANYTIME ||
      program.trainingDate.type === TRAINING_DATE_AS_THE_GROUP_FORM ||
      program.trainingDate.type === TRAINING_DATE_REQUEST ||
      (program.trainingDate.type === TRAINING_DATE_CALENDAR && program.trainingDate.extra.length > 0)
    ) {
      result += 5
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
