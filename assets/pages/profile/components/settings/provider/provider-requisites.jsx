import React from 'react'

import { Input, NumberInput } from '@/components/react-ui/input'

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
      <NumberInput
        placeholder={'ИНН *'}
        maxLength={10}
        value={requisites.ITN}
        setValue={(value) => setRequisites({...requisites, ITN: value})}
      />
      <NumberInput
        placeholder={'КПП'}
        maxLength={9}
        value={requisites.IEC}
        setValue={(value) => setRequisites({...requisites, IEC: value})}
      />
      <NumberInput
        placeholder={'ОГРН *'}
        maxLength={13}
        value={requisites.PSRN}
        setValue={(value) => setRequisites({...requisites, PSRN: value})}
      />
      <NumberInput
        placeholder={'ОКПО'}
        maxLength={14}
        value={requisites.OKPO}
        setValue={(value) => setRequisites({...requisites, OKPO: value})}
      />
      <NumberInput
        placeholder={'Р/с *'}
        maxLength={20}
        value={requisites.checkingAccount}
        setValue={(value) => setRequisites({...requisites, checkingAccount: value})}
      />
      <NumberInput
        placeholder={'К/с *'}
        maxLength={20}
        value={requisites.correspondentAccount}
        setValue={(value) => setRequisites({...requisites, correspondentAccount: value})}
      />
      <NumberInput
        type={'text'}
        placeholder={'БИК *'}
        maxLength={9}
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
