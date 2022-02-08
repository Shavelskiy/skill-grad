import React from 'react'

import { FETCH_USERS_URL } from '../../utils/api/endpoints'

import IndexPageTemplate from '../../components/page-templates'
import { actions, table } from './table'


const UsersIndex = () => {
  return (
    <IndexPageTemplate
      title={'Список пользователей'}
      icon={'users'}
      table={table}
      actions={actions}
      fetchUrl={FETCH_USERS_URL}
      canCreate={true}
    />
  )
}

export default UsersIndex
