import React from 'react'

import ProviderSettingsUser from './provider-settings-user'
import ProviderSettingsOrganization from './provider-settings-organization'

import css from './provider-settings.scss?module'
import cn from 'classnames'


const ProviderSettings = () => {
  return (
    <div className={cn('container-0', css.container0, css.settings)}>
      <h3 className={cn('w-100', 'result-title', css.resultTitle)}>Настройки пользователя</h3>
      <ProviderSettingsUser/>
      <ProviderSettingsOrganization/>
    </div>
  )
}

export default ProviderSettings
