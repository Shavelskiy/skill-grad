import React from 'react'

import axios from 'axios'
import { SAVE_URL } from '@/utils/program-form/endpoints'

import {
  validateAnnotation,
  validateCategories,
  validateDuration,
  validateFormat,
  validateKnowledgeCheck,
  validateLevel,
  validateName,
  validateOccupationMode,
  validatePrice,
  validateProgramDesign,
  validateProgramLocations,
  validateTrainingDate
} from '@/helpers/validate-program-form'

import { useSelector, useDispatch } from 'react-redux'
import { resetProgramForm } from './../../redux/program/actions'
import { setAllActive } from './../../redux/validation/actions'

import css from './result-buttons.scss?module'
import cn from 'classnames'


const ResultButtons = () => {
  const dispatch = useDispatch()
  const program = useSelector(state => state.program)

  const validateProgram = () => {
    dispatch(setAllActive())

    return (
      validateName(program) &&
      validateCategories(program) &&
      validateAnnotation(program) &&
      validateDuration(program) &&
      validateFormat(program) &&
      validateProgramDesign(program) &&
      validateKnowledgeCheck(program) &&
      validateLevel(program) &&
      validateTrainingDate(program) &&
      validateOccupationMode(program) &&
      validatePrice(program) &&
      validateProgramLocations(program)
    );
  }

  const saveProgram = (setActive = false) => {
    const formData = new FormData()

    const data = {
      ...program,
      teachers: program.teachers.map(teacher => teacher.name),
      newProviders: program.newProviders.map(newProvider => {
        return {
          name: newProvider.name,
          link: newProvider.link,
          comment: newProvider.comment,
        }
      }),
      certificateName: program.certificate.name,
      gallery: program.gallery.map(item => item.name),
      active: setActive,
    }

    formData.append('json_content', JSON.stringify(data))

    program.teachers.forEach((item, key) => {
      if (item.image !== null) {
        formData.append(`teachers[${key}]`, item.image)
      }
    })

    program.newProviders.forEach((item, key) => {
      if (item.image !== null) {
        formData.append(`newProviders[${key}]`, item.image)
      }
    })

    if (program.certificate.file !== null) {
      formData.append('certificateImage', program.certificate.file)
    }

    program.gallery.forEach((item, key) => {
      formData.append(`gallery[${key}]`, item.image)
    })

    axios.post(SAVE_URL, formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
      .then((response) => console.log(response))
  }

  return (
    <div className={css.buttonContainer}>
      <div
        className={cn(css.button, css.cancel)}
        onClick={() => dispatch(resetProgramForm())}
      >
        Отменить
      </div>
      <div
        className={cn(css.button, css.save)}
        onClick={() => {
          if (validateProgram()) {
            saveProgram()
          }
        }}
      >
        Сохранить
      </div>
      <div
        className={cn(css.button, css.publish)}
        onClick={() => {
          if (validateProgram()) {
            saveProgram(true)
          }
        }}
      >
        Опубликовать
      </div>
    </div>
  )
}

export default ResultButtons
