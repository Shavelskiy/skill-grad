import React, { useState, useEffect } from 'react'

import axios from 'axios'
import { FETCH_ALL_PROVIDERS } from '../../utils/endpoints'

import { useDispatch, useSelector } from 'react-redux'
import { chooseProvidersFromList, setProviderList } from '../../redux/actions'

import Modal from '../ui/modal'
import Button from '../ui/button'

import css from './ choose-provider-popup.scss?module'
import cn from 'classnames'
import noImage from './../../img/provider-image.png'


const ChooseProviderPopup = ({active, close, selectedProvidersIds}) => {
  const dispatch = useDispatch()

  const providerList = useSelector(state => state.providerList)
  const [providersIds, setProvidersIds] = useState(null)

  const [searchQuery, setSerchQuery] = useState('')

  useEffect(() => {
    axios.get(FETCH_ALL_PROVIDERS)
      .then(({data}) => dispatch(setProviderList(data)))
  }, [])

  useEffect(() => {
    if (selectedProvidersIds === null) {
      return
    }

    setProvidersIds(selectedProvidersIds)
  }, [selectedProvidersIds])

  const handleProviderClick = (providerId) => {
    if (providersIds.indexOf(providerId) === -1) {
      setProvidersIds([...providersIds, providerId])
    } else {
      setProvidersIds(providersIds.filter(id => providerId !== id))
    }
  }

  const handleSubmitButton = () => {
    dispatch(chooseProvidersFromList(providersIds))
    close()
  }

  const renderProviderList = () => {
    return providerList.filter(provider => {
      if (searchQuery === '') {
        return true
      }

      return provider.name.toUpperCase().indexOf(searchQuery.toUpperCase()) !== -1

    }).map((provider, key) => {
      return (
        <div key={key} className={css.itemWrap} onClick={() => handleProviderClick(provider.id)}>
          <div className={cn(css.item, {[css.selected]: providersIds.indexOf(provider.id) !== -1})}>
            <div className={css.image}>
              <img src={provider.image !== null ? provider.image : noImage}/>
            </div>
            <div className={css.description}>{provider.name}</div>
          </div>
        </div>
      )
    })
  }

  return (
    <Modal
      active={active}
      close={close}
      title={'Добавить провайдера SkillGrad'}
    >
      <div className={css.inputWrap}>
        <input
          type={'text'}
          placeholder={'Поиск по названию провайдера'}
          value={searchQuery}
          onChange={(event) => setSerchQuery(event.target.value)}
        />
        <button type={'button'}></button>
      </div>
      <div className={css.providerListContainer}>
        <div className={css.providerList}>
          {renderProviderList()}
        </div>
      </div>
      <div className={css.buttonContainer}>
        <Button
          text={'Добавить'}
          blue={true}
          click={handleSubmitButton}
        />
      </div>
    </Modal>
  )
}

export default ChooseProviderPopup
