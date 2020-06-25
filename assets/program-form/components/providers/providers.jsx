import React, { useState } from 'react'

import { PROVIDERS } from '../../utils/titles'

import { useDispatch, useSelector } from 'react-redux'
import { deleteProvider } from '../../redux/actions'

import Block from '../ui/block'
import ControlPopup from './control-popup'
import ProviderCreate from './create-provider'
import ChooseProviderPopup from './choose-provider-popup'

import css from './providers.scss?module'
import cn from 'classnames'

import deleteImage from './../../img/delete.svg'
import editImage from './../../img/pencil.svg'
import ProviderUpdate from './provider-update'


const Providers = () => {
  const dispatch = useDispatch()

  const providers = useSelector(state => state.providers)

  const [controlPopupActive, setControlPopupActive] = useState(false)
  const [providersPopupActive, setProvidersPopupActive] = useState(false)
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
              onClick={() => dispatch(deleteProvider(key))}
            />
          </div>
        )
      case 'old':
        return <></>
      default:
        return <></>
    }
  }

  const renderProviderList = () => {
    return providers.map((provider, key) => {
      return (
        <div key={key} className={css.teacher}>
          {/*<img src={URL.createObjectURL(provider.image)}/>*/}
          <div className={css.info}>
            <div className={cn(css.title, {[css.outside]: provider.type === 'new'})}>
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
        {renderProviderList()}
      </div>
    </Block>
  )
}

export default Providers
