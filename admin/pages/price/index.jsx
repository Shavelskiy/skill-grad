import React from 'react'

import { FETCH_PRICES_URL } from '../../utils/api/endpoints'

import IndexPageTemplate from '../../components/page-templates'
import { table, actions } from './table'

const PriceIndex = () => {
  return (
    <IndexPageTemplate
      title={'Список платных услуг'}
      icon={'ruble-sign'}
      table={table}
      actions={actions}
      fetchUrl={FETCH_PRICES_URL}
      canCreate={false}
    />
  )
}

export default PriceIndex
