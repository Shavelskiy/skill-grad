import React, { useState } from 'react'

import { PROVIDERS } from '../../utils/titles'

import { useDispatch, useSelector } from 'react-redux'
import { deleteNewProvider } from '../../redux/actions'

import Block from '../ui/block'
import ControlPopup from './control-popup'
import ProviderCreate from './create-provider'
import ChooseProviderPopup from './choose-provider-popup'
import ProviderUpdate from './provider-update'

import css from './providers.scss?module'
import cn from 'classnames'

import noImage from './../../img/provider-image.png'
import deleteImage from './../../img/delete.svg'
import editImage from './../../img/pencil.svg'


const Providers = () => {
  const dispatch = useDispatch()

  const newProviders = useSelector(state => state.newProviders)

  const [controlPopupActive, setControlPopupActive] = useState(false)
  const [providersPopupActive, setProvidersPopupActive] = useState(true)
  const [newProviderPopupActive, setNewProviderPopupActive] = useState(false)
  const [updateProviderPopupActive, setUpdateProviderPopupActive] = useState(false)

  const [updatedProvider, setUpdatedProvider] = useState(null)

  const renderTooltip = (provider) => {
    if (provider.type !== 'new') {
      return <></>
    }

    return <div className={css.tooltip}>Ссылка ведет на другой ресурс</div>
  }

  const renderActions = (provider, key) => {
    switch (provider.type) {
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
      case 'old':
        return <></>
      default:
        return <></>
    }
  }

  const renderPorviderImage = (provider) => {
    if (provider.image === null) {
      return <img src={noImage}/>
    }

    return <img src={URL.createObjectURL(provider.image)}/>
  }

  const renderProviderList = (providers, type) => {
    return providers.map((provider, key) => {
      if (provider.image !== null) {

      }
      return (
        <div key={key} className={css.teacher}>
          <div>
            {renderPorviderImage(provider)}
          </div>
          <div className={css.info}>
            <div className={cn(css.title, {[css.outside]: type === 'new'})}>
              <a target='_blank' href={provider.link}>
                {provider.name}
                {renderTooltip(provider)}
              </a>
              {renderActions(provider, key)}
            </div>
            <div className={css.comment}>{provider.comment}</div>
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
    >
      <ControlPopup
        active={controlPopupActive}
        close={() => setControlPopupActive(false)}
        showProvidersPopup={() => setProvidersPopupActive(true)}
        showNewProviderPopup={() => setNewProviderPopupActive(true)}
      />

      <ChooseProviderPopup
        selectedProvidersIds={useSelector(state => state.selectedProvidersIds)}
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

      <div className={css.teacherContainer}>
        {renderProviderList(newProviders)}
      </div>
    </Block>
  )
}

export default Providers
