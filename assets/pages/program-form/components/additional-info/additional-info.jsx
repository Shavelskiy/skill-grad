import React from 'react'

import {ADDITIONAL_INFO} from '@/utils/program-form/titles'

import {useSelector, useDispatch} from 'react-redux'
import {setAdditionalInfo} from '../../redux/program/actions'
import {focusAdditional} from './../../redux/validation/actions'

import Block from '@/components/react-ui/program-form/block'
import {Textarea} from '@/components/react-ui/program-form/input'

import css from './additional-info.scss?module'


const AdditionalInfo = () => {
  const dispatch = useDispatch()

  return (
    <Block title={ADDITIONAL_INFO} containerClass={css.container} onFocus={focusAdditional}>
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
