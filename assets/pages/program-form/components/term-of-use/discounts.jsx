import React from 'react'

import { useSelector, useDispatch } from 'react-redux'
import { setDiscounts } from '../../redux/program/actions'

import RadioButton from '@/components/react-ui/program-form/radio-button'
import { NumberInput } from '@/components/react-ui/program-form/input'

import css from './term-of-use.scss?module'
import cn from 'classnames'


const Discounts = () => {
  const dispatch = useDispatch()

  const discounts = useSelector(state => state.program.discounts)
  const price = useSelector(state => state.program.price)

  const getDiscountValue = (price, discount) => {
    const value = price * (1 - discount / 100)
    return Math.floor(value * 100) / 100
  }

  return (
    <>
      <h3>Скидки:</h3>
      <RadioButton
        checked={discounts.legalEntity.checked}
        click={() => dispatch(setDiscounts({
          ...discounts,
          legalEntity: {...discounts.legalEntity, checked: !discounts.legalEntity.checked}
        }))}
        disabled={discounts.byRequest}
      >
        <span className={css.numberInputTitle}>Для юридических лиц</span>
        <div className={css.percentInputContainer}>
          <NumberInput
            value={discounts.legalEntity.value}
            small={true}
            maxValue={99}
            disabled={discounts.byRequest}
            setValue={(value) => dispatch(setDiscounts({
              ...discounts,
              legalEntity: {...discounts.legalEntity, value: value}
            }))}
          />
        </div>
        % -
        <div className={cn(css.numberInputContainer, css.discountInputContainer)}>
          <NumberInput
            value={getDiscountValue(price.legalEntity.price, discounts.legalEntity.value)}
            small={true}
            disabled={true}
          />
        </div>
        руб.
      </RadioButton>
      <RadioButton
        checked={discounts.individual.checked}
        click={() => dispatch(setDiscounts({
          ...discounts,
          individual: {...discounts.individual, checked: !discounts.individual.checked}
        }))}
        disabled={discounts.byRequest}
      >
        <span className={css.numberInputTitle}>Для физических лиц</span>
        <div className={css.percentInputContainer}>
          <NumberInput
            value={discounts.individual.value}
            small={true}
            maxValue={99}
            disabled={discounts.byRequest}
            setValue={(value) => dispatch(setDiscounts({
              ...discounts,
              individual: {...discounts.individual, value: value}
            }))}
          />
        </div>
        % -
        <div className={cn(css.numberInputContainer, css.discountInputContainer)}>
          <NumberInput
            value={getDiscountValue(price.individual.price, discounts.individual.value)}
            small={true}
            disabled={true}
          />
        </div>
        руб.
      </RadioButton>
      <RadioButton
        checked={discounts.byRequest}
        click={() => dispatch(setDiscounts({...discounts, byRequest: !discounts.byRequest}))}
        disabled={discounts.legalEntity.checked || discounts.individual.checked}
      >
        По запросу
      </RadioButton>
    </>
  )
}

export default Discounts
