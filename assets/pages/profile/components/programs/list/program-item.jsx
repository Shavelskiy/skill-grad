import React, {useState} from 'react'
import {PROGRAM_QUESTIONS, PROGRAM_REQUESTS, PROGRAM_REVIEWS} from '@/utils/profile/routes'

import Request from './request'
import PaidServiceModal from '../modals/paid-service-modal'
import MoneyNoAvailableModal from '../modals/money-no-available-modal'
import DeactivateModal from '../modals/deactivate-modal'
import DeleteProgramModal from '../modals/delete-program-modal'

import css from './scss/program-item.scss?module'
import cn from 'classnames'


const ProgramItem = ({program}) => {
  const [paidServiceModalActive, setPaidServiceModalActive] = useState(false)
  const [moneyNoAvailableModalActive, setMoneyNoAvailableModalActive] = useState(false)
  const [deactivateModalActive, setDeactivateModalActive] = useState(false)
  const [deleteProgramModalActive, setDeleteProgramModalActive] = useState(false)

  return (
    <tr>
      <td className={css.programFirstColumn}>
        <a href={program.link} target="_blank">{program.name}</a>
      </td>
      <td className="mobile-p-b">
        <span className={css.categories}>{program.categories}</span>
      </td>
      <Request
        link={PROGRAM_REQUESTS}
        programId={program.id}
        values={program.requests}
        name='Заявки'
      />
      <Request
        link={PROGRAM_QUESTIONS}
        programId={program.id}
        values={program.questions}
        name='Вопросы'
      />
      <Request
        link={PROGRAM_REVIEWS}
        programId={program.id}
        values={program.reviews}
        name='Оценки'
      />
      <td>
        <div className={css.actions}>
          <span className={cn('icon', 'goal', css.item)} onClick={() => setPaidServiceModalActive(true)}></span>
          <span className={cn('icon', 'status', css.item)} onClick={() => setDeactivateModalActive(true)}></span>
          <span className={cn('icon', 'pencil', css.item)}></span>
          <span className={cn('icon', 'delete', css.item)} onClick={() => setDeleteProgramModalActive(true)}></span>
        </div>

        <PaidServiceModal
          active={paidServiceModalActive}
          close={() => setPaidServiceModalActive(false)}
          openNoAvailableModal={() => {
            setPaidServiceModalActive(false)
            setMoneyNoAvailableModalActive(true)
          }}
        />

        <MoneyNoAvailableModal
          active={moneyNoAvailableModalActive}
          close={() => setMoneyNoAvailableModalActive(false)}
        />

        <DeactivateModal
          active={deactivateModalActive}
          close={() => setDeactivateModalActive(false)}
        />

        <DeleteProgramModal
          active={deleteProgramModalActive}
          close={() => setDeleteProgramModalActive(false)}
        />
      </td>
    </tr>
  )
}

export default ProgramItem
