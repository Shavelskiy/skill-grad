import React from 'react'

import { TextInput } from '../../components/ui/inputs'


const ProviderRequisitesForm = ({item, setItem}) => {
  return (
    <form>
      <TextInput
        value={item.organizationName}
        setValue={(organizationName) => setItem({...item, organizationName: organizationName})}
        label="Наименование организации"
      />

      <TextInput
        value={item.legalAddress}
        setValue={(legalAddress) => setItem({...item, legalAddress: legalAddress})}
        label="Юридический адрес"
      />

      <TextInput
        value={item.mailingAddress}
        setValue={(mailingAddress) => setItem({...item, mailingAddress: mailingAddress})}
        label="Почтовый адрес"
      />

      <TextInput
        value={item.ITN}
        setValue={(ITN) => setItem({...item, ITN: ITN})}
        label="ИНН"
      />

      <TextInput
        value={item.IEC}
        setValue={(IEC) => setItem({...item, IEC: IEC})}
        label="КПП"
      />

      <TextInput
        value={item.PSRN}
        setValue={(PSRN) => setItem({...item, PSRN: PSRN})}
        label="ОГРН"
      />

      <TextInput
        value={item.OKPO}
        setValue={(OKPO) => setItem({...item, OKPO: OKPO})}
        label="ОКПО"
      />

      <TextInput
        value={item.checkingAccount}
        setValue={(checkingAccount) => setItem({...item, checkingAccount: checkingAccount})}
        label="Расчетный счет"
      />

      <TextInput
        value={item.correspondentAccount}
        setValue={(correspondentAccount) => setItem({...item, correspondentAccount: correspondentAccount})}
        label="Корреспондентский счёт"
      />

      <TextInput
        value={item.BIC}
        setValue={(BIC) => setItem({...item, BIC: BIC})}
        label="БИК"
      />

      <TextInput
        value={item.bank}
        setValue={(bank) => setItem({...item, bank: bank})}
        label="Банк"
      />

    </form>
  )
}

export default ProviderRequisitesForm
