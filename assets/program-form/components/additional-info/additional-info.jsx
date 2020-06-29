import React from 'react'

import { ADDITIONAL_INFO } from '../../utils/titles'

import { useSelector, useDispatch } from 'react-redux'
import { setAdditionalInfo } from '../../redux/program/actions'

import Block from '../ui/block'
import { Textarea } from '../ui/input'

import css from './additional-info.scss?module'


const AdditionalInfo = () => {
  const dispatch = useDispatch()

  return (
    <Block title={ADDITIONAL_INFO} containerClass={css.container}>
      <Textarea
        placeholder={'Дополнительная информация'}
        value={useSelector(state => state.program.additionalInfo)}
        setValue={(value) => dispatch(setAdditionalInfo(value))}
        extraLarge={true}
      />
    </Block>
  )
}

export default AdditionalInfo
