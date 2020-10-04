import React from 'react'

import Modal from '../../../components/modal/modal'
import {Button} from '@/components/react-ui/buttons'

import css from './scss/modals.scss?module'


const DeactivateModal = ({active, close}) => {
  return (
    <Modal
      active={active}
      close={close}
      title={''}
    >
      <p className={css.title}>
        Программ будет деактивирована и не видна пользователям
      </p>
      <p className={css.title}>
        Она будет доступна во вкладке «Неактивные программы»
      </p>
      <Button
        text={'Деактивировать программу'}
        red={true}
        click={() => console.log('kek')}
      />
    </Modal>
  )
}

export default DeactivateModal
