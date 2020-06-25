import React, {useState} from 'react'
import Block from '../ui/block'

import { PROVIDERS } from '../../utils/titles'
import ControlPopup from './control-popup'
import NewProviderPopup from './new-provider-popup'
import ChooseProviderPopup from './choose-provider-popup'


const Providers = () => {
  const [controlPopupActive, setControlPopupActive] = useState(false)
  const [providersPopupActive, setProvidersPopupActive] = useState(false)
  const [newProviderPopupActive, setNewProviderPopupActive] = useState(false)

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

      <NewProviderPopup
        active={newProviderPopupActive}
        close={() => setNewProviderPopupActive(false)}
      />
    </Block>
  )
}

export default Providers
