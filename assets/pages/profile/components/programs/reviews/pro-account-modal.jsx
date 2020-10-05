import React, {useState} from 'react'
import {useHistory} from 'react-router-dom'
import {PAYMENTS} from '@/utils/profile/routes'

import axios from 'axios'
import {BUY_PRO_ACCOUNT} from '@/utils/profile/endpoints'

import {useSelector, useDispatch} from 'react-redux'
import {setProAccount, setProviderBalance} from '../../../redux/actions'

import Modal from '@/pages/profile/components/modal/modal'
import {Button} from '@/components/react-ui/buttons'

import css from '@/pages/profile/components/programs/reviews/scss/pro-account-modal.scss?module'


const ProAccountModal = ({active, close}) => {
  const history = useHistory()
  const dispatch = useDispatch()

  const proAccountPrice = useSelector((state) => state.proAccountPrice)
  const balance = useSelector((state) => state.balance)

  const [noMoneyModalActive, setNoMoneyModalActive] = useState(false)

  const buyProAccount = () => {
    if (balance < proAccountPrice) {
      close()
      setNoMoneyModalActive(true)
      return
    }

    axios.post(BUY_PRO_ACCOUNT)
      .then(() => {
        dispatch(setProAccount(true))
        dispatch(setProviderBalance(balance - proAccountPrice))
      })
  }

  return (
    <>
      <Modal
        active={active}
        close={close}
        title={''}
      >
        <p className="text">
          Чтобы писать ответы на отзывы необходимо приобрести тариф Pro. Цена {proAccountPrice} руб. с НДС в месяц
        </p>
        <div className={css.buttonContainer}>
          <Button
            text={'Отменить'}
            red={true}
            fullWidth={false}
            click={() => close()}
          />
          <Button
            text={'Купить'}
            blue={true}
            fullWidth={false}
            click={buyProAccount}
          />
        </div>
      </Modal>

      <Modal
        active={noMoneyModalActive}
        close={() => setNoMoneyModalActive(false)}
        title={''}
      >
        <p className="text">На вашем счету<br/>недостаточно средств</p>

        <div className={css.buttonContainer}>
          <Button
            text={'Отменить'}
            red={true}
            fullWidth={false}
            click={() => setNoMoneyModalActive(false)}
          />
          <Button
            text={'Пополнить'}
            blue={true}
            fullWidth={false}
            click={() => history.push(PAYMENTS)}
          />
        </div>

      </Modal>
    </>
  )
}

export default ProAccountModal
