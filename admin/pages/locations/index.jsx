import React from 'react'
import { LOCATION_CREATE } from '../../utils/routes'

import { FETCH_LOCATIONS_URL } from '../../utils/api/endpoints'

import IndexPageTemplate from '../../components/page-templates'
import { table, actions } from './table'


const LocationsIndex = () => {
  return (
    <IndexPageTemplate
      title={'Список всех местоположений'}
      icon={'globe'}
      table={table}
      actions={actions}
      fetchUrl={FETCH_LOCATIONS_URL}
      canCreate={true}
      createLink={LOCATION_CREATE}
    />
  )
}

export default LocationsIndex
