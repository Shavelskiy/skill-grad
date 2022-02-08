import React from 'react'
import { PROGRAM_FORMAT_CREATE } from '../../utils/routes'

import { FETCH_PROGRAMS_FORMAT_URL } from '../../utils/api/endpoints'

import IndexPageTemplate from '../../components/page-templates'
import { table, actions } from './table'

const ProgramFormatIndex = () => {
  return (
    <IndexPageTemplate
      title={'Формы обучения'}
      icon={'moon'}
      table={table}
      actions={actions}
      fetchUrl={FETCH_PROGRAMS_FORMAT_URL}
      canCreate={true}
      createLink={PROGRAM_FORMAT_CREATE}
    />
  )
}

export default ProgramFormatIndex
