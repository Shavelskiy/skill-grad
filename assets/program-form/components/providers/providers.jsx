import React, { useState } from 'react'

import { PROVIDERS } from '../../utils/titles'

import { useDispatch, useSelector } from 'react-redux'
import { chooseProvidersFromList, deleteNewProvider } from '../../redux/program/actions'

import Block from '../ui/block'
import ControlPopup from './control-popup'
import ProviderCreate from './create-provider'
import ChooseProviderPopup from './choose-provider-popup'
import ProviderUpdate from './provider-update'

import css from './scss/providers.scss?module'
import cn from 'classnames'

import noImage from './../../../img/provider-image.png'
import deleteImage from './../../../img/svg/delete.svg'
import editImage from './../../../img/svg/pencil.svg'


const Providers = () => {
  const dispatch = useDispatch()

  const providerList = useSelector(state => state.data.providerList)

  const currentProvider = useSelector(state => state.data.currentProvider)
  const newProviders = useSelector(state => state.program.newProviders)
  const selectedProviderIds = useSelector(state => state.program.selectedProvidersIds)

  const [controlPopupActive, setControlPopupActive] = useState(false)
  const [providersPopupActive, setProvidersPopupActive] = useState(false)
  const [newProviderPopupActive, setNewProviderPopupActive] = useState(false)
  const [updateProviderPopupActive, setUpdateProviderPopupActive] = useState(false)

  const [updatedProvider, setUpdatedProvider] = useState(null)

  const renderActions = (provider, key, type) => {
    switch (type) {
      case 'new':
        return (
          <div className={css.actions}>
            <img
              src={editImage}
              onClick={() => {
                setUpdatedProvider({key: key, provider: provider})
                setUpdateProviderPopupActive(true)
              }}
            />
            <img
              src={deleteImage}
              onClick={() => dispatch(deleteNewProvider(key))}
            />
          </div>
        )
      case 'list':
        return (
          <div className={css.actions}>
            <img
              src={deleteImage}
              onClick={() => dispatch(chooseProvidersFromList(selectedProviderIds.filter(id => id !== provider.id)))}
            />
          </div>
        )
      default:
        return <></>
    }
  }

  const renderProviderImage = (provider, type) => {
    if (provider.image === null) {
      return <img src={noImage}/>
    }

    switch (type) {
      case 'new':
        return <img src={URL.createObjectURL(provider.image)}/>
      case 'current':
      case 'list':
        return <img src={provider.image}/>
      default:
        return <img src={noImage}/>
    }
  }

  const renderProviderList = (providers, type) => {
    return providers
      .filter(provider => provider !== null)
      .map((provider, key) => {
      return (
        <div key={key} className={css.provider}>
          <div className={css.logo}>
            {renderProviderImage(provider, type)}
            {(type === 'new') ? <div className={css.description}>Провайдера нет в базе SillGrad</div> : <></>}
          </div>
          <div className={css.info}>
            <div className={cn(css.title, {[css.outside]: type === 'new'})}>
              <a target='_blank' href={provider.link}>
                {provider.name}
                {(type === 'new') ? <div className={css.tooltip}>Ссылка ведет на другой ресурс</div> : <></>}
              </a>
              {renderActions(provider, key, type)}
            </div>
            <div className={css.comment}>
              {provider.comment}
            </div>
          </div>
        </div>
      )
    })
  }

  return (
    <Block
      title={PROVIDERS}
      link={'Добавить провайдера'}
      linkClick={() => setControlPopupActive(true)}
      containerClass={css.container}
    >
      <ControlPopup
        active={controlPopupActive}
        close={() => setControlPopupActive(false)}
        showProvidersPopup={() => setProvidersPopupActive(true)}
        showNewProviderPopup={() => setNewProviderPopupActive(true)}
      />

      <ChooseProviderPopup
        selectedProvidersIds={selectedProviderIds}
        active={providersPopupActive}
        close={() => setProvidersPopupActive(false)}
      />

      <ProviderCreate
        active={newProviderPopupActive}
        close={() => setNewProviderPopupActive(false)}
      />

      <ProviderUpdate
        active={updateProviderPopupActive}
        close={() => setUpdateProviderPopupActive(false)}
        providerData={updatedProvider}
      />

      <div className={css.providerContainer}>
        {renderProviderList([currentProvider], 'current')}
        {renderProviderList(providerList.filter(provider => selectedProviderIds.indexOf(provider.id) !== -1), 'list')}
        {renderProviderList(newProviders, 'new')}
      </div>
    </Block>
  )
}

export default Providers
