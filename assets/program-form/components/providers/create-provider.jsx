import React, { useState } from 'react'

import { useDispatch } from 'react-redux'
import { addNewProvider } from '../../redux/program/actions'

import ProviderFormPopup from './provider-form-popup'

const emptyProvider = {
  name: '',
  link: '',
  comment: '',
  image: null,
}

const ProviderCreate = ({active, close}) => {
  const dispatch = useDispatch()

  const [provider, setProvider] = useState(emptyProvider)

  const handleSubmit = () => {
    dispatch(addNewProvider(provider))
    setProvider(emptyProvider)
    close()
  }

  return (
    <ProviderFormPopup
      active={active}
      close={close}
      provider={provider}
      setProvider={setProvider}
      sumbit={handleSubmit}
    />
  )
}

export default ProviderCreate
