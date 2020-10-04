import React from 'react'

import {useSelector} from 'react-redux'

import {HIGHLIGHT, RAISE, HIGHLIGHT_RAISE} from '@/utils/profile/porgram-service-types'

import Modal from '../../modal/modal'
import {SmallButton} from '@/components/react-ui/buttons'

import css from './scss/paid-service-modal.scss?module'


const PaidServiceModal = ({active, close, openNoAvailableModal, addPaidService, services}) => {
  const programPrices = useSelector((state) => state.programPrices)
  const balance = useSelector((state) => state.balance)

  const chooseService = (type) => {
    if (programPrices[type] > balance) {
      openNoAvailableModal()
      return
    }

    addPaidService(type, programPrices[type])
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
          text={`Купить за ${programPrices[HIGHLIGHT]} руб`}
          click={() => chooseService(HIGHLIGHT)}
          disabled={services[HIGHLIGHT]}
          blue={true}
        />
      </div>
      <div className={css.blockModal}>
        <p className={css.text}><strong>Однократно поднять</strong> <br/> в результатах поиска</p>
        <SmallButton
          text={`Купить за ${programPrices[RAISE]} руб`}
          click={() => chooseService(RAISE)}
          disabled={services[RAISE]}
          blue={true}
        />
      </div>
      <div className={css.blockModal}>
        <p className={css.text}><strong>Выделить цветом +</strong> <br/> <strong>Однократно поднять</strong></p>
        <SmallButton
          text={`Купить за ${programPrices[HIGHLIGHT_RAISE]} руб`}
          click={() => chooseService(HIGHLIGHT_RAISE)}
          disabled={services[HIGHLIGHT] && services[RAISE]}
          red={true}
        />
      </div>
    </Modal>
  )
}

export default PaidServiceModal
