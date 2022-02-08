import React from 'react'

import { useSelector, useDispatch } from 'react-redux'
import { setPrice } from '../../redux/program/actions'

import RadioButton from '@/components/react-ui/program-form/radio-button'
import { NumberInput } from '@/components/react-ui/program-form/input'

import css from './term-of-use.scss?module'


const Price = ({error = false}) => {
  const dispatch = useDispatch()

  const price = useSelector(state => state.program.price)

  return (
    <>
      <h3>Стоимость:</h3>
      <RadioButton
        checked={price.legalEntity.checked}
        click={() => dispatch(setPrice({
          ...price,
          legalEntity: {...price.legalEntity, checked: !price.legalEntity.checked}
        }))}
        disabled={price.byRequest}
        error={error}
      >
        <span className={css.numberInputTitle}>Для юридических лиц</span>
        <div className={css.numberInputContainer}>
          <NumberInput
            value={price.legalEntity.price}
            small={true}
            disabled={price.byRequest}
            setValue={(value) => dispatch(setPrice({...price, legalEntity: {...price.legalEntity, price: value}}))}
            error={error}
          />
        </div>
        руб.
      </RadioButton>
      <RadioButton
        checked={price.individual.checked}
        click={() => dispatch(setPrice({
          ...price,
          individual: {...price.individual, checked: !price.individual.checked}
        }))}
        disabled={price.byRequest}
        error={error}
      >
        <span className={css.numberInputTitle}>Для физических лиц</span>
        <div className={css.numberInputContainer}>
          <NumberInput
            value={price.individual.price}
            small={true}
            disabled={price.byRequest}
            setValue={(value) => dispatch(setPrice({...price, individual: {...price.individual, price: value}}))}
            error={error}
          />
        </div>
        руб.
      </RadioButton>
      <RadioButton
        checked={price.byRequest}
        click={() => dispatch(setPrice({...price, byRequest: !price.byRequest}))}
        disabled={price.legalEntity.checked || price.individual.checked}
        error={error}
      >
        По запросу
      </RadioButton>
    </>
  )
}

export default Price
