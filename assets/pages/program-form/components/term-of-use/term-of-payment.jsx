import React from 'react'

import { useDispatch, useSelector } from 'react-redux'
import { setTermOfPayment } from '../../redux/program/actions'

import RadioButton from '@/components/react-ui/program-form/radio-button'
import { Textarea } from '@/components/react-ui/program-form/input'

import css from './term-of-use.scss?module'
import cn from 'classnames'


const TermOfPayment = () => {
  const dispatch = useDispatch()

  const termOfPayment = useSelector(state => state.program.termOfPayment)

  return (
    <>
      <h3>Условия оплаты:</h3>
      <RadioButton
        checked={termOfPayment.legalEntity.checked}
        click={() => dispatch(setTermOfPayment({
          ...termOfPayment,
          legalEntity: {...termOfPayment.legalEntity, checked: !termOfPayment.legalEntity.checked}
        }))}
        disabled={termOfPayment.byRequest}
      >
        <span className={css.numberInputTitle}>Для юридических лиц</span>
      </RadioButton>
      <div className={cn(css.termOfPaymentContainer, {[css.hidden]: !termOfPayment.legalEntity.checked})}>
        <Textarea
          placeholder={'Введите условия оплаты для юридических лиц'}
          value={termOfPayment.legalEntity.value}
          setValue={(value) => dispatch(setTermOfPayment({
            ...termOfPayment,
            legalEntity: {...termOfPayment.legalEntity, value: value}
          }))}
        />
      </div>
      <RadioButton
        checked={termOfPayment.individual.checked}
        click={() => dispatch(setTermOfPayment({
          ...termOfPayment,
          individual: {...termOfPayment.individual, checked: !termOfPayment.individual.checked}
        }))}
        disabled={termOfPayment.byRequest}
      >
        <span className={css.numberInputTitle}>Для физических лиц</span>
      </RadioButton>
      <div className={cn(css.termOfPaymentContainer, {[css.hidden]: !termOfPayment.individual.checked})}>
        <Textarea
          placeholder={'Введите условия оплаты для физических лиц'}
          value={termOfPayment.individual.value}
          setValue={(value) => dispatch(setTermOfPayment({
            ...termOfPayment,
            individual: {...termOfPayment.individual, value: value}
          }))}
        />
      </div>
      <RadioButton
        checked={termOfPayment.byRequest}
        click={() => dispatch(setTermOfPayment({...termOfPayment, byRequest: !termOfPayment.byRequest}))}
        disabled={termOfPayment.legalEntity.checked || termOfPayment.individual.checked}
      >
        По запросу
      </RadioButton>
    </>
  )
}

export default TermOfPayment
