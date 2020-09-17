import React from 'react'
import Modal from '../../modal/modal'


const PayServiceModal = () => {
  return (
    <Modal
      active={active}
      close={close}
      title={'Выберите платную услугу'}
    >
      <div className="block-modal d-flex">
        <p className="text"><strong>Выделить цветом</strong> <br/> на 30 дней</p>
        <button className="button-b">Купить за 990 руб</button>
      </div>
      <div className="block-modal d-flex">
        <p className="text"><strong>Однократно поднять</strong> <br/> в результатах поиска</p>
        <button className="button-b">Купить за 490 руб</button>
      </div>
      <div className="block-modal d-flex">
        <p className="text"><strong>Выделить цветом +</strong> <br/> <strong>Однократно поднять</strong></p>
        <button className="button-r">Купить за 490 руб</button>
      </div>
    </Modal>
  )
}

export default PayServiceModal
