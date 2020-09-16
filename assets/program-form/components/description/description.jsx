import React, { useState, useEffect } from 'react'
import { DESCRIPTION } from '../../utils/titles'

import { useDispatch, useSelector } from 'react-redux'
import { setName, setCategory, setAnnotation, setDetailText } from '../../redux/program/actions'

import { TextInput, Textarea } from '../ui/input'
import Select from '../ui/select'
import Block from '../ui/block'
import Teachers from './teachers'
import Duration from './duration'

import css from './description.scss?module'
import cn from 'classnames'


const Description = () => {
  const dispatch = useDispatch()
  const [showErrors, setShowErrors] = useState({
    name: false,
  })

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
    <Block title={DESCRIPTION} containerClass={css.container}>
      <TextInput
        value={name}
        error={showErrors.name && name.length < 10}
        placeholder={'Название программы обучения'}
        setValue={(value) => {
          setShowErrors({...showErrors, name: true})
          dispatch(setName(value))
        }}
      />
      <div className={cn(css.categroies, css.fieldContainer)}>
        {[...Array(3).keys()].map(key => {
          return (
            <div className={css.categorySelect} key={key}>
              <Select
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
          value={useSelector(state => state.program.annotation)}
          setValue={(annotation) => dispatch(setAnnotation(annotation))}
          extraSmall={true}
        />
      </div>
      <div className={css.fieldContainer}>
        <Textarea
          placeholder={'Программа обучения'}
          value={useSelector(state => state.program.detailText)}
          setValue={(detailText) => dispatch(setDetailText(detailText))}
          extraSmall={true}
        />
      </div>
      <div className={css.inputContainer}>
        <Teachers/>
      </div>
      <div className={css.inputContainer}>
        <Duration/>
      </div>
    </Block>
  )
}

export default Description
