import React, { useState } from 'react'
import { DESCRIPTION } from '@/utils/program-form/titles'

import { useDispatch, useSelector } from 'react-redux'
import { setName, setCategory, setAnnotation, setDetailText } from '../../redux/program/actions'
import { focusDescription } from './../../redux/validation/actions'

import {
  validateAnnotation,
  validateCategories,
  validateDetailText, validateDuration,
  validateName
} from '@/helpers/validate-program-form'

import { TextInput, Textarea } from '@/components/react-ui/program-form/input'
import Select from '@/components/react-ui/select'
import Block from '@/components/react-ui/program-form/block'

import Teachers from './teachers'
import Duration from './duration'

import css from './scss/description.scss?module'
import cn from 'classnames'


const Description = () => {
  const dispatch = useDispatch()

  const blockActive = useSelector((state) => state.validation.description.active)
  const program = useSelector(state => state.program)
  const name = useSelector(state => state.program.name)

  const getCategoriesOptions = (key) => {
    const selectedCategories = useSelector(state => state.program.categories)
    return useSelector(state => state.data.categories).filter(option => {
      return selectedCategories.filter((selectedCategory, valueKey) => {
        return (valueKey !== key) && (selectedCategory === option.value)
      }).length < 1
    })
  }

  return (
    <Block title={DESCRIPTION} containerClass={css.container} onFocus={focusDescription}>
      <TextInput
        value={name}
        error={blockActive && !validateName(program)}
        placeholder={'Название программы обучения'}
        setValue={(value) => dispatch(setName(value))}
      />
      <div className={cn(css.categories, css.fieldContainer)}>
        {[...Array(3).keys()].map(key => {
          return (
            <div className={css.categorySelect} key={key}>
              <Select
                error={blockActive && !validateCategories(program)}
                placeholder={'Выбрать категорию'}
                value={useSelector(state => state.program.categories[key])}
                setValue={(value) => dispatch(setCategory(key, value))}
                options={getCategoriesOptions(key)}
              />
            </div>
          )
        })}
      </div>
      <div className={css.fieldContainer}>
        <Textarea
          placeholder={'Аннотация программы обучения'}
          error={blockActive && !validateAnnotation(program)}
          value={useSelector(state => state.program.annotation)}
          setValue={(annotation) => dispatch(setAnnotation(annotation))}
          extraSmall={true}
        />
      </div>
      <div className={css.fieldContainer}>
        <Textarea
          placeholder={'Программа обучения'}
          error={blockActive && !validateDetailText(program)}
          value={useSelector(state => state.program.detailText)}
          setValue={(detailText) => dispatch(setDetailText(detailText))}
          extraSmall={true}
        />
      </div>
      <div className={css.inputContainer}>
        <Teachers/>
      </div>
      <div className={css.inputContainer}>
        <Duration error={blockActive && !validateDuration(program)}/>
      </div>
    </Block>
  )
}

export default Description
