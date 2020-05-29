import React from 'react'
import { LOCATION_CREATE } from '../../utils/routes'

import { FETCH_LOCATIONS_URL } from '../../utils/api/endpoints'

import IndexPageTemplate from '../../components/page-templates'


const table = [
  {
    title: 'Id',
    name: 'id',
  },
  {
    title: 'Название',
    name: 'name',
  },
  {
    title: 'Тип',
    name: 'type',
  },
  {
    title: 'Сортировка',
    name: 'sort',
  }
]

const actions = [
  {
    type: 'view',
    link: '/tag',
  },
  {
    type: 'update',
    link: '/tag',
  },
  {
    type: 'delete',
    link: '/api/admin/location/',
  }
]

const LocationsIndex = () => {
  return (
    <IndexPageTemplate
      title={'Список всех местоположений'}
      table={table}
      actions={actions}
      fetchUrl={FETCH_LOCATIONS_URL}
      canCreate={true}
      createLink={LOCATION_CREATE}
    />
  )
}

export default LocationsIndex
