import React from 'react'

import {useSelector} from 'react-redux'

import Modal from '../../modal/modal'
import {SmallButton} from '@/components/react-ui/buttons'

import css from './scss/paid-service-modal.scss?module'


const PaidServiceModal = ({active, close, openNoAvailableModal}) => {
  const programPrices = useSelector((state) => state.programPrices)
  const balance = useSelector((state) => state.balance)

  const chooseService = (type) => {
    if (programPrices[type] > balance) {
      openNoAvailableModal()
      return
    }

    console.log('kek')
  }

  return (
    <Modal
      active={active}
      close={close}
      title={'Выберите платную услугу'}
    >
      <div className={css.blockModal}>
        <p className={css.text}><strong>Выделить цветом</strong> <br/> на 30 дней</p>
        <SmallButton
          text={`Купить за ${programPrices.highlight} руб`}
          click={() => chooseService('highlight')}
          blue={true}
        />
      </div>
      <div className={css.blockModal}>
        <p className={css.text}><strong>Однократно поднять</strong> <br/> в результатах поиска</p>
        <SmallButton
          text={`Купить за ${programPrices.raise} руб`}
          click={() => chooseService('raise')}
          blue={true}
        />
      </div>
      <div className={css.blockModal}>
        <p className={css.text}><strong>Выделить цветом +</strong> <br/> <strong>Однократно поднять</strong></p>
        <SmallButton
          text={`Купить за ${programPrices.highlight_raise} руб`}
          click={() => chooseService('highlight_raise')}
          red={true}
        />
      </div>
    </Modal>
  )
}

export default PaidServiceModal
