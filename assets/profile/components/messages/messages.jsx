import React, {useState, useEffect} from 'react'

import axios from 'axios'
import {MESSAGE_INDEX_URL} from '../../utils/api/endpoints'

import Sidebar from './sidebar'
import DetailChat from './detail-chat'

import css from './messages.scss?module'


const Messages = () => {
  const [groups, setGroups] = useState([])
  const [selectedRecipientId, setSelectedRecipientId] = useState(null)

  useEffect(() => {
    axios.get(MESSAGE_INDEX_URL)
      .then(({data}) => {
        setGroups(data.groups)
      })
  }, [])

  return (
    <div className="container-0 mt-40 non-margin-mobile">
      <div className={css.messages}>
        <Sidebar
          groups={groups}
          click={(recipientId) => setSelectedRecipientId(selectedRecipientId === recipientId ? null : recipientId)}
        />
        <DetailChat
          recipientId={selectedRecipientId}
        />
      </div>
    </div>
  )
}

export default Messages
