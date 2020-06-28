import React from 'react'

import { TERM_OF_USE } from '../../utils/titles'

import { useDispatch, useSelector } from 'react-redux'
import { setActions, setShowPriceReduction } from '../../redux/actions'

import Block from '../ui/block'
import EnumList from '../ui/enum-list'
import Price from './price'
import Discounts from './discounts'
import FavoriteProvider from './favorite-provider'
import TermOfPayment from './term-of-payment'

import css from './term-of-use.scss?module'
import cn from 'classnames'


const TermOfUse = () => {
  const dispatch = useDispatch()

  const showPriceReduction = useSelector(state => state.showPriceReduction)

  return (
    <Block title={TERM_OF_USE}>
      <div className={css.inputContainer}>
        <Price/>
      </div>

      <div className={css.inputContainer}>
        <h3>Показывать снижение цены</h3>
        <div className={css.switcherContainer} onClick={() => dispatch(setShowPriceReduction(!showPriceReduction))}>
          <span className={cn(css.switcher, {[css.selected]: showPriceReduction})}></span>
        </div>
        <span className={css.description}>
          Если вводится новая, более низкая цена, то: новая показана красным цветом, а старая чёрным и перечеркнута
        </span>
      </div>

      <div className={css.inputContainer}>
        <Discounts/>
      </div>

      <div className={css.inputContainer}>
        <EnumList
          title={'Акции от провайдера'}
          values={useSelector(state => state.actions)}
          setValues={(values) => dispatch(setActions(values))}
          wide={true}
        />
      </div>

      <div className={css.inputContainer}>
        <FavoriteProvider/>
      </div>

      <div className={css.inputContainer}>
        <TermOfPayment/>
      </div>

    </Block>
  )
}

export default TermOfUse
