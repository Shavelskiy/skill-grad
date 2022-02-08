import React from 'react'
import { PROGRAM_LEVEL_CREATE } from '../../utils/routes'

import { FETCH_PROGRAMS_LEVEL_URL } from '../../utils/api/endpoints'

import IndexPageTemplate from '../../components/page-templates'
import { table, actions } from './table'

const ProgramLevelIndex = () => {
  return (
    <IndexPageTemplate
      title={'Уровни'}
      icon={'layer-group'}
      table={table}
      actions={actions}
      fetchUrl={FETCH_PROGRAMS_LEVEL_URL}
      canCreate={true}
      createLink={PROGRAM_LEVEL_CREATE}
    />
  )
}

export default ProgramLevelIndex
