import React from 'react'

import Input from '../../ui/input'


const ProviderRequisites = ({requisites, setRequisites}) => {
  return (
    <div className="container-0 mt-20">
      <div className="col-lg-4 col-md-12 col-sm-4">
        <Input
          type={'text'}
          placeholder={'Наименование организации *'}
          value={requisites.organizationName}
          setValue={(value) => setRequisites({...requisites, organizationName: value})}
        />
      </div>
      <div className="col-lg-4 col-md-12 col-sm-4">
        <Input
          type={'text'}
          placeholder={'Юридический адрес *'}
          value={requisites.legalAddress}
          setValue={(value) => setRequisites({...requisites, legalAddress: value})}
        />
      </div>
      <div className="col-lg-4 col-md-12 col-sm-4 pr-0">
        <Input
          type={'text'}
          placeholder={'Почтовый адрес'}
          value={requisites.mailingAddress}
          setValue={(value) => setRequisites({...requisites, mailingAddress: value})}
        />
      </div>
      <div className="col-lg-3 col-md-12 col-sm-4 pl-0">
        <Input
          type={'text'}
          placeholder={'ИНН *'}
          value={requisites.ITN}
          setValue={(value) => setRequisites({...requisites, ITN: value})}
        />
      </div>
      <div className="col-lg-3 col-md-12 col-sm-4">
        <Input
          type={'text'}
          placeholder={'КПП'}
          value={requisites.IEC}
          setValue={(value) => setRequisites({...requisites, IEC: value})}
        />
      </div>
      <div className="col-lg-3 col-md-12 col-sm-4">
        <Input
          type={'text'}
          placeholder={'ОГРН *'}
          value={requisites.PSRN}
          setValue={(value) => setRequisites({...requisites, PSRN: value})}
        />
      </div>
      <div className="col-lg-3 col-md-12 col-sm-4 pr-0">
        <Input
          type={'text'}
          placeholder={'ОКПО'}
          value={requisites.OKPO}
          setValue={(value) => setRequisites({...requisites, OKPO: value})}
        />
      </div>
      <div className="col-lg-3 col-md-12 col-sm-4 pl-0">
        <Input
          type={'text'}
          placeholder={'Р/с *'}
          value={requisites.checkingAccount}
          setValue={(value) => setRequisites({...requisites, checkingAccount: value})}
        />
      </div>
      <div className="col-lg-3 col-md-12 col-sm-4">
        <Input
          type={'text'}
          placeholder={'К/с *'}
          value={requisites.correspondentAccount}
          setValue={(value) => setRequisites({...requisites, correspondentAccount: value})}
        />
      </div>
      <div className="col-lg-3 col-md-12 col-sm-4">
        <Input
          type={'text'}
          placeholder={'БИК *'}
          value={requisites.BIC}
          setValue={(value) => setRequisites({...requisites, BIC: value})}
        />
      </div>
      <div className="col-lg-3 col-md-12 col-sm-4">
        <Input
          type={'text'}
          placeholder={'Банк *'}
          value={requisites.bank}
          setValue={(value) => setRequisites({...requisites, bank: value})}
        />
      </div>
    </div>
  )
}

export default ProviderRequisites
