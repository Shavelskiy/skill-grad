import React from 'react'

import { useDispatch, useSelector } from 'react-redux'
import { setFavoriteProviderAction } from '../../redux/actions'

import { NumberInput } from '../ui/input'

import css from './term-of-use.scss?module'
import cn from 'classnames'


const FavoriteProvider = () => {
  const dispatch = useDispatch()

  const favoriteProviderAction = useSelector(state => state.favoriteProviderAction)

  return (
    <>
      <h3>Акция «Любимый провайдер»:</h3>
      <div className={css.favoriteProviderActionRow}>
        При приобретении первого курса скидка
        <div className={css.valueContainer}>
          <NumberInput
            value={favoriteProviderAction.firstDiscount}
            maxValue={99}
            setValue={(value) => dispatch(setFavoriteProviderAction({
              ...favoriteProviderAction,
              firstDiscount: value
            }))}
          />
        </div>
        %
      </div>
      <div className={css.favoriteProviderActionRow}>
        При приобретении последующих курсов скидка
        <div className={css.valueContainer}>
          <NumberInput
            value={favoriteProviderAction.nextDiscount}
            maxValue={99}
            setValue={(value) => dispatch(setFavoriteProviderAction({
              ...favoriteProviderAction,
              nextDiscount: value
            }))}
          />
        </div>
        %
      </div>
      <div className={cn(css.favoriteProviderActionRow, css.link)}>
        Условия читайте по ссылке&nbsp;
        <a href={'/'} target={'_blank'}>ссылке</a>
      </div>
    </>
  )
}

export default FavoriteProvider
