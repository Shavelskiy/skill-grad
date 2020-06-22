import React from 'react'
import { PROGRAM_ADDITIONAL_CREATE } from '../../utils/routes'

import { FETCH_PROGRAMS_ADDITIONAL_URL } from '../../utils/api/endpoints'

import IndexPageTemplate from '../../components/page-templates'
import { table, actions } from './table'

const ProgramAdditionalIndex = () => {
  return (
    <IndexPageTemplate
      title={'Дополнительные пункты программы обучения'}
      icon={'abacus'}
      table={table}
      actions={actions}
      fetchUrl={FETCH_PROGRAMS_ADDITIONAL_URL}
      canCreate={true}
      createLink={PROGRAM_ADDITIONAL_CREATE}
    />
  )
}

export default ProgramAdditionalIndex
