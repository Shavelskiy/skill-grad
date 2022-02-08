import React from 'react'
import { PROGRAM_INCLUDE_CREATE } from '../../utils/routes'

import { FETCH_PROGRAMS_INCLUDE_URL } from '../../utils/api/endpoints'

import IndexPageTemplate from '../../components/page-templates'
import { table, actions } from './table'

const ProgramIncludeIndex = () => {
  return (
    <IndexPageTemplate
      title={'Включено в курс'}
      icon={'abacus'}
      table={table}
      actions={actions}
      fetchUrl={FETCH_PROGRAMS_INCLUDE_URL}
      canCreate={true}
      createLink={PROGRAM_INCLUDE_CREATE}
    />
  )
}

export default ProgramIncludeIndex
