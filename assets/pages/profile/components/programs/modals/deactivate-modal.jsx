import React from 'react'

import Modal from '../../../components/modal/modal'
import {Button} from '@/components/react-ui/buttons'

import css from './scss/modals.scss?module'


const DeactivateModal = ({active, close, deactivate, activate, isActive}) => {
  const renderTextForDeactivate = () => {
    return (
      <>
        <p className={css.title}>
          Программ будет деактивирована и не видна пользователям
        </p>
        <p className={css.title}>
          Она будет доступна во вкладке «Неактивные программы»
        </p>
      </>
    )
  }

  const renderTextForActivate = () => {
    return (
      <>
        <p className={css.title}>
          Программ будет активирована и видна пользователям
        </p>
        <p className={css.title}>
          Она будет доступна во вкладке «Активные программы»
        </p>
      </>
    )
  }

  return (
    <Modal
      active={active}
      close={close}
      title={''}
    >
      {isActive ? renderTextForDeactivate() : renderTextForActivate()}
      <Button
        text={isActive ? 'Деактивировать программу' : 'Активировать программу'}
        red={isActive}
        blue={!isActive}
        click={() => isActive ? deactivate() : activate()}
      />
    </Modal>
  )
}

export default DeactivateModal
