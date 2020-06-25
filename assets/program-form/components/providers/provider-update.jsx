import React, { useState } from 'react'

import { useDispatch, useSelector } from 'react-redux'
import { addNewProvider } from '../../redux/actions'

import ProviderFormPopup from './provider-form-popup'


const ProviderUpdate = ({active, close, providerKey}) => {


  const dispatch = useDispatch()
  const [provider, setProvider] = useSelector(state => state.providers.filter((item, key) => key === providerKey)[0])
  // const [tmpProvider, setTmpProvider] = useState(provider)


  const handleSubmit = () => {
    // console.log(tmpProvider)
    // dispatch(addNewProvider(provider))
    // setProvider(emptyProvider)
    // close()
  }

  console.log(provider)
  if (!provider) {
    return <></>
  }

  return (
    <ProviderFormPopup
      active={active}
      close={close}
      provider={provider}
      setProvider={setTmpProvider}
      sumbit={handleSubmit}
    />
  )
}

export default ProviderUpdate
