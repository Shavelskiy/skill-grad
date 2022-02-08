import React from 'react'

import { FETCH_FEEDBACK_LIST_URL } from '../../utils/api/endpoints'

import IndexPageTemplate from '../../components/page-templates'
import { table, actions } from './table'

const FeedbackIndex = () => {
  return (
    <IndexPageTemplate
      title={'Список вопросов'}
      icon={'comments'}
      table={table}
      actions={actions}
      fetchUrl={FETCH_FEEDBACK_LIST_URL}
      canCreate={false}
    />
  )
}

export default FeedbackIndex
