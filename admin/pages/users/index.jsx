import React from 'react'
import { TAG_CREATE } from '../../utils/routes'

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
      createLink={TAG_CREATE}
    />
  )
}

export default UsersIndex
