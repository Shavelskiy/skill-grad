import React from 'react'

import ProviderSettingsUser from './provider-settings-user'
import ProviderSettingsOrganization from './provider-settings-organization'

import css from './provider-settings.scss?module'
import cn from 'classnames'


const ProviderSettings = () => {
  return (
    <div>
      <h3 className={cn('w-100', 'result-title', css.resultTitle)}>Настройки пользователя</h3>
      <ProviderSettingsUser/>
      <h3 className={cn('w-100', 'result-title', css.resultTitle)}>Настройки организации</h3>
      <ProviderSettingsOrganization/>
    </div>
  )
}

export default ProviderSettings
