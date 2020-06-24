import React, { useState } from 'react'

import { TextInput, Textarea } from '../ui/input'
import Select from '../ui/select'
import Block from '../ui/block'

import { DESCRIPTION } from '../../utils/titles'

import css from './description.scss?module'
import cn from 'classnames'


const Description = () => {
  const [name, setName] = useState('')
  const [category, setCategroy] = useState(1)

  const options = [
    {
      title: 'Архитектура',
      value: 1,
    },
    {
      title: 'Дизайн',
      value: 2,
    },
    {
      title: 'История',
      value: 3,
    },
  ]

  return (
    <Block title={DESCRIPTION}>
      <TextInput
        value={name}
        placeholder={'Название программы обучения'}
        required={true}
        setValue={setName}
      />
      <div className={cn(css.categroies, css.inputContainer)}>
        <div className={css.categorySelect}>
          <Select
            value={category}
            setValue={setCategroy}
            options={[...options, ...options, ...options, ...options, ...options]}
          />
        </div>
        <div className={css.categorySelect}>
          <Select
            value={category}
            setValue={setCategroy}
            options={[...options, ...options, ...options, ...options, ...options]}
          />
        </div>
        <div className={css.categorySelect}>
          <Select
            value={category}
            setValue={setCategroy}
            options={[...options, ...options, ...options, ...options, ...options]}
          />
        </div>
      </div>
      <div className={css.inputContainer}>
        <Textarea
          placeholder={'Аннотация программы обучения'}
          value={name}
          setValue={setName}
        />
      </div>
      <div className={css.inputContainer}>
        <Textarea
          placeholder={'Программа обучения'}
          value={name}
          setValue={setName}
        />
      </div>
    </Block>
  )
}

export default Description
