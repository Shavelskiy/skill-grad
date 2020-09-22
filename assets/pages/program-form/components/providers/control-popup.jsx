import React from 'react'

import Modal from '@/components/react-ui/program-form/modal'
import Button from '@/components/react-ui/program-form/button'

import css from './scss/control-popup.scss?module'


const ControlPopup = ({active, close, showProvidersPopup, showNewProviderPopup}) => {
  const handleButtonClick = (showNewPopup) => {
    close()
    showNewPopup()
  }

  return (
    <Modal
      active={active}
      close={close}
      title={'Добавить провайдера'}
    >
      <div className={css.controlPopup}>
        <Button
          text={'Провайдер из базы SkillGrad'}
          blue={true}
          click={() => handleButtonClick(showProvidersPopup)}
        />
        <Button
          text={'Новый провайдер'}
          red={true}
          click={() => handleButtonClick(showNewProviderPopup)}
        />
      </div>
    </Modal>
  )
}

export default ControlPopup
