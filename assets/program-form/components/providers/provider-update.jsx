import React, { useState, useEffect } from 'react'

import { useDispatch } from 'react-redux'
import { updateNewProvider } from '../../redux/actions'

import ProviderFormPopup from './provider-form-popup'


const ProviderUpdate = ({active, close, providerData = null}) => {
  const dispatch = useDispatch()

  const [newProvider, setNewProvider] = useState(null)

  const handleSubmit = () => {
    dispatch(updateNewProvider(newProvider, providerData.key))
    close()
  }

  useEffect(() => {
    if (providerData === null) {
      return
    }
    setNewProvider(providerData.provider)
  }, [providerData])

  if (providerData === null || newProvider === null) {
    return <></>
  }

  return (
    <ProviderFormPopup
      active={active}
      close={close}
      provider={newProvider}
      setProvider={setNewProvider}
      sumbit={handleSubmit}
      update={true}
    />
  )
}

export default ProviderUpdate
