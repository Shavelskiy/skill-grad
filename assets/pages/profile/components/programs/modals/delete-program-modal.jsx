import React from 'react'

import Modal from '../../../components/modal/modal'
import { Button } from '@/components/react-ui/buttons'

import css from './scss/modals.scss?module'


const DeleteProgramModal = ({active, close, deleteProgram}) => {
  return (
    <Modal
      active={active}
      close={close}
      title={''}
    >
      <p className={css.title}>
        Вы хотите удалить данную программу без возможности восстановления?
      </p>
      <div className={css.deleteButtons}>
        <Button
          text={'Нет'}
          blue={true}
          fullWidth={false}
          click={() => close()}
        />
        <Button
          text={'Да'}
          red={true}
          fullWidth={false}
          click={() => deleteProgram()}
        />
      </div>
    </Modal>
  )
}

export default DeleteProgramModal
