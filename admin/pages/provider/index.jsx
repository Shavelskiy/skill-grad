import React from 'react'
import { PROVIDER_CREATE } from '../../utils/routes'

import { FETCH_PROVIDERS_URL } from '../../utils/api/endpoints'

import IndexPageTemplate from '../../components/page-templates'
import { table, actions } from './table'


const ProviderIndex = () => {
  return (
    <IndexPageTemplate
      title={'Провайдеры обучения'}
      icon={'chalkboard-teacher'}
      table={table}
      actions={actions}
      fetchUrl={FETCH_PROVIDERS_URL}
      canCreate={true}
      createLink={PROVIDER_CREATE}
    />
  )
}

export default ProviderIndex
