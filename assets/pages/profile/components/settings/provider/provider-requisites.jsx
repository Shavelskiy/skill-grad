import React from 'react'

import {Input} from '@/components/react-ui/input'

import css from './scss/provider-requisites.scss?module'


const ProviderRequisites = ({requisites, setRequisites}) => {
  return (
    <div className={css.requisitesContainer}>
      <Input
        type={'text'}
        placeholder={'Наименование организации *'}
        value={requisites.organizationName}
        setValue={(value) => setRequisites({...requisites, organizationName: value})}
      />
      <Input
        type={'text'}
        placeholder={'Юридический адрес *'}
        value={requisites.legalAddress}
        setValue={(value) => setRequisites({...requisites, legalAddress: value})}
      />
      <Input
        type={'text'}
        placeholder={'Почтовый адрес'}
        value={requisites.mailingAddress}
        setValue={(value) => setRequisites({...requisites, mailingAddress: value})}
      />
      <Input
        type={'text'}
        placeholder={'ИНН *'}
        value={requisites.ITN}
        setValue={(value) => setRequisites({...requisites, ITN: value})}
      />
      <Input
        type={'text'}
        placeholder={'КПП'}
        value={requisites.IEC}
        setValue={(value) => setRequisites({...requisites, IEC: value})}
      />
      <Input
        type={'text'}
        placeholder={'ОГРН *'}
        value={requisites.PSRN}
        setValue={(value) => setRequisites({...requisites, PSRN: value})}
      />
      <Input
        type={'text'}
        placeholder={'ОКПО'}
        value={requisites.OKPO}
        setValue={(value) => setRequisites({...requisites, OKPO: value})}
      />
      <Input
        type={'text'}
        placeholder={'Р/с *'}
        value={requisites.checkingAccount}
        setValue={(value) => setRequisites({...requisites, checkingAccount: value})}
      />
      <Input
        type={'text'}
        placeholder={'К/с *'}
        value={requisites.correspondentAccount}
        setValue={(value) => setRequisites({...requisites, correspondentAccount: value})}
      />
      <Input
        type={'text'}
        placeholder={'БИК *'}
        value={requisites.BIC}
        setValue={(value) => setRequisites({...requisites, BIC: value})}
      />
      <Input
        type={'text'}
        placeholder={'Банк *'}
        value={requisites.bank}
        setValue={(value) => setRequisites({...requisites, bank: value})}
      />
    </div>
  )
}

export default ProviderRequisites
