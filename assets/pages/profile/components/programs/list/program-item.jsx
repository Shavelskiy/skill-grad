import React, {useState} from 'react'
import {PROGRAM_QUESTIONS, PROGRAM_REQUESTS, PROGRAM_REVIEWS} from '@/utils/profile/routes'

import axios from 'axios'
import {PROGRAM_DEACTIVATE_URL, PROGRAM_ACTIVATE_URL} from '@/utils/profile/endpoints'

import Request from './request'
import PaidServiceModal from '../modals/paid-service-modal'
import MoneyNoAvailableModal from '../modals/money-no-available-modal'
import DeactivateModal from '../modals/deactivate-modal'
import DeleteProgramModal from '../modals/delete-program-modal'

import css from './scss/program-item.scss?module'
import cn from 'classnames'


const ProgramItem = ({program, reload}) => {
  const [paidServiceModalActive, setPaidServiceModalActive] = useState(false)
  const [moneyNoAvailableModalActive, setMoneyNoAvailableModalActive] = useState(false)
  const [deactivateModalActive, setDeactivateModalActive] = useState(false)
  const [deleteProgramModalActive, setDeleteProgramModalActive] = useState(false)

  const deactivateProgram = () => {
    axios.post(PROGRAM_DEACTIVATE_URL.replace(':id', program.id))
      .then(() => {
        reload()
        setDeactivateModalActive(false)
      })
  }

  const activateProgram = () => {
    axios.post(PROGRAM_ACTIVATE_URL.replace(':id', program.id))
      .then(() => {
        reload()
        setDeactivateModalActive(false)
      })
  }

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
          <div className={css.item} onClick={() => setPaidServiceModalActive(true)}>
            <span className={cn('icon', 'goal')}></span>
            <div className={css.notification}>
              Выбрать платную услугу
            </div>
          </div>

          <div className={css.item} onClick={() => setDeactivateModalActive(true)}>
            <span className={cn('icon', 'status', {'not': !program.active})}></span>
            <div className={css.notification}>
              {program.active ? 'Снять программу с публикации' : 'Опубликовать программу'}
            </div>
          </div>

          <a className={css.item} href={`/program-create?id=${program.id}`}>
            <span className={cn('icon', 'pencil')}></span>
            <div className={css.notification}>
              Редактировать программу
            </div>
          </a>

          <div className={css.item} onClick={() => setDeleteProgramModalActive(true)}>
            <span className={cn('icon', 'delete')}></span>
            <div className={css.notification}>
              Удалить программу
            </div>
          </div>
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
          deactivate={deactivateProgram}
          activate={activateProgram}
          isActive={program.active}
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
