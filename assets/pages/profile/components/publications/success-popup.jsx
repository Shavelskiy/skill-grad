import React from 'react'

import Modal from '@/pages/profile/components/modal/modal'


const SuccessPopup = ({active, close}) => {
  return (
    <Modal
      active={active}
      close={close}
      title={''}
    >
      <p>Ваша статья направлена модератору.</p>
      <p>После модерации она будет опубликована.</p>
    </Modal>
  )
}

export default SuccessPopup
