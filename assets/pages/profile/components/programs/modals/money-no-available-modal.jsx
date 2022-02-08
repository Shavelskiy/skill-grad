import React from 'react'

import { useHistory } from 'react-router-dom'
import { PAYMENTS } from '@/utils/profile/routes'

import { Button } from '@/components/react-ui/buttons'
import Modal from '../../../components/modal/modal'

import css from './scss/modals.scss?module'


const MoneyNoAvailableModal = ({active, close}) => {
  const history = useHistory()

  return (
    <Modal
      active={active}
      close={close}
      title={''}
    >
      <p className={css.title}>
        На вашем счете недостаточно средств, пополните баланс
      </p>
      <Button
        text={'Пополнить баланс'}
        click={() => history.push(PAYMENTS)}
        blue={true}
      />
    </Modal>
  )
}

export default MoneyNoAvailableModal
