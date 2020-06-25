import React from 'react'
import { DESCRIPTION } from '../../utils/titles'

import { useDispatch, useSelector } from 'react-redux'
import { setName, setCategory, setAnnotation, setDetailText } from '../../redux/actions'

import { TextInput, Textarea } from '../ui/input'
import Select from '../ui/select'
import Block from '../ui/block'
import Teachers from '../teachers/teachers'

import css from './description.scss?module'
import cn from 'classnames'


const Description = () => {
  const dispatch = useDispatch()

  const options = [ // todo
    {
      title: 'Архитектура',
      value: 1,
    },
    {
      title: 'Дизайн',
      value: 2,
    },
  ]

  const getCategoriesOptions = (key) => {
    const selectedCategories = useSelector(state => state.categories)
    return options.filter(option => {
      return selectedCategories.filter((selectedCategory, valueKey) => {
        return (valueKey !== key) && (selectedCategory === option.value)
      }).length < 1
    })
  }

  return (
    <Block title={DESCRIPTION}>
      <TextInput
        value={useSelector(state => state.name)}
        placeholder={'Название программы обучения'}
        required={true}
        setValue={(name) => dispatch(setName(name))}
      />
      <div className={cn(css.categroies, css.inputContainer)}>
        {[...Array(3).keys()].map(key => {
          return (
            <div className={css.categorySelect} key={key}>
              <Select
                placeholder={'Выбрать категорию'}
                value={useSelector(state => state.categories[key])}
                setValue={(value) => dispatch(setCategory(key, value))}
                options={getCategoriesOptions(key)}
              />
            </div>
          )
        })}
      </div>
      <div className={css.inputContainer}>
        <Textarea
          placeholder={'Аннотация программы обучения'}
          value={useSelector(state => state.annotation)}
          setValue={(annotation) => dispatch(setAnnotation(annotation))}
        />
      </div>
      <div className={css.inputContainer}>
        <Textarea
          placeholder={'Программа обучения'}
          value={useSelector(state => state.detailText)}
          setValue={(detailText) => dispatch(setDetailText(detailText))}
        />
      </div>
      <div className={css.inputContainer}>
        <Teachers/>
      </div>
    </Block>
  )
}

export default Description
