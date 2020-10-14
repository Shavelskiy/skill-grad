import React from 'react'

import { FETCH_FAQS_URL } from '../../utils/api/endpoints'
import { FAQ_CREATE } from '../../utils/routes'

import IndexPageTemplate from '../../components/page-templates'
import { actions, table } from './table'


const FaqIndex = () => {
  return (
    <IndexPageTemplate
      title={'FAQ'}
      icon={'sticky-note'}
      table={table}
      actions={actions}
      fetchUrl={FETCH_FAQS_URL}
      canCreate={true}
      createLink={FAQ_CREATE}
    />
  )
}

export default FaqIndex
