import React from 'react'

import ProviderSettingsUser from './provider-settings-user'
import ProviderSettingsOrganization from './provider-settings-organization'
import {ResultTitle} from '@/components/react-ui/blocks'


const ProviderSettings = () => {
  return (
    <div>
      <ResultTitle title={'Настройки пользователя'}/>
      <ProviderSettingsUser/>
      <ResultTitle title={'Настройки организации'}/>
      <ProviderSettingsOrganization/>
    </div>
  )
}

export default ProviderSettings
